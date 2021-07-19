<?php

namespace booking\entities\user;

use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\entities\booking\WishlistItemInterface;
use booking\entities\Lang;
use booking\helpers\scr;
use ReflectionClass;
use Yii;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * ___________________________________________property string $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @property Network[] $networks
 * @property Personal $personal
 * @property Preferences $preferences
 * @property UserMailing $mailing
 * @property BookingTour[] bookingTours
 * @property BookingCar[] bookingCars
 * @property WishlistTour[] wishlistTours
 * @property WishlistCar[] wishlistCars
 * @property WishlistFun[] wishlistFuns
 * @property WishlistStay[] wishlistStays
 * @property WishlistFood[] wishlistFoods
 * @property WishlistProduct[] wishlistProducts
 * @property ForumRead[] $forumsRead
 * property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    public static function create(string $username, string $email, string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->status = self::STATUS_ACTIVE;
        $user->created_at = time();
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->generateAuthKey();
        $user->personal = Personal::create('', null, new UserAddress(), new FullName(), false);
        $user->preferences = Preferences::create();
        $user->mailing = UserMailing::create();
        //$user->generateEmailVerificationToken();
        return $user;
    }

    public function updatePersonal(Personal $personal): void
    {
        if (!empty($personal->phone)) $this->username = $personal->phone;
        $this->personal = $personal;
        if ($this->created_at > time() - 60) $this->updated_at = time();
    }

    public function updatePreferences(Preferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public function updateMailing(UserMailing $mailing)
    {
        $this->mailing = $mailing;
    }


    public function edit(string $username, string $email): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->updated_at = time();
        $personal = $this->personal;
        $personal->phone = $username;
        $this->personal = $personal;
    }

    //Не используется
    public static function signup(string $username, string $email, string $password): self
    {
        $user = User::create($username, $email, $password);
        $user->status = self::STATUS_ACTIVE;
        $user->generateEmailVerificationToken();
        return $user;
    }

    public static function signupByNetwork($network, $identity, $email = null): self
    {
        $user = new User();
        $user->created_at = time();
        if ($email) $user->email = $email;
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->networks = [Network::create($network, $identity)];

        $user->personal = Personal::create('', null, new UserAddress(), new FullName(), false);
        $user->preferences = Preferences::create();
        $user->mailing = UserMailing::create();
        return $user;
    }

    public function attachNetwork($network, $identity): void
    {
        $networks = $this->networks;
        foreach ($networks as $current) {
            if ($current->isFor($network, $identity)) {
                throw new \DomainException(Lang::t('Соцсеть уже подключена'));
            }
        }
        $networks[] = Network::create($network, $identity);
        $this->networks = $networks;
    }

    public function disconnectNetwork($network, $identity): void
    {
        $networks = $this->networks;
        foreach ($networks as $i => $current) {
            if ($current->isFor($network, $identity)) {
                unset($networks[$i]);
                $this->networks = $networks;
                return;
            }
        }
        throw new \DomainException(Lang::t('Соцсеть не найдена'));
    }

    public function isActive(): bool
    {
        if ($this->status === self::STATUS_ACTIVE) return true;
        return false;
    }

    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException(Lang::t('Пароль уже был сброшен'));
        }
        $this->generatePasswordResetToken();
    }

    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException(Lang::t('Сброшенный пароль не подтвержден'));
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            //TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'networks',
                    'personal',
                    'preferences',
                    'bookingTours',
                    'wishlistTours',
                    'wishlistCars',
                    'wishlistFuns',
                    'wishlistStays',
                    'wishlistFoods',
                    'wishlistProducts',
                    'mailing',
                    'forumsRead',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    //********** ForumRead ********************
    public function readForum($post_id)
    {
        $forums = $this->forumsRead;
        foreach ($forums as &$forum) {
            if ($forum->isFor($post_id)) {
                $forum->edit();
                $this->forumsRead = $forums;
                return;
            }
        }
        $forums[] = ForumRead::create($post_id);
        $this->forumsRead = $forums;
    }

    public function isReadForum($post_id, $post_update_at): bool
    {
        $forums = $this->forumsRead;
        foreach ($forums as $forum) {
            if ($forum->isFor($post_id) && $forum->last_at >= $post_update_at) {
                return true;
            }
        }
        return false;
    }

    /** Tours ===================> */
//Не используется
    public function addBookingTours($calendar_id, Cost $count)
    {
        $bookings = $this->bookingTours;
        $booking = BookingTour::create($calendar_id, $count);
        $bookings[] = $booking;
        $this->bookingTours = $bookings;
    }

    //Не используется
    public function editBookingTours($id, Cost $cost)
    {

        $bookings = $this->bookingTours;
        foreach ($bookings as $i => &$booking) {
            if ($booking->isFor($id)) {
                $booking->edit($cost);
                $this->bookingTours = $bookings;
                return;
            }
        }
        throw new \DomainException(Lang::t('Бронирование не найдено'));
    }

    public function payBookingTours($id)
    {
        $bookings = $this->bookingTours;
        foreach ($bookings as $i => &$booking) {
            if ($booking->isFor($id)) {
                $booking->pay();
                $this->bookingTours = $bookings;
                return;
            }
        }
        throw new \DomainException(Lang::t('Бронирование не найдено'));
    }

    public function cancelBookingTours($id)
    {
        $bookings = $this->bookingTours;
        foreach ($bookings as $i => &$booking) {
            if ($booking->isFor($id)) {
                $booking->cancel();
                $this->bookingTours = $bookings;
                return;
            }
        }
        throw new \DomainException(Lang::t('Бронирование не найдено'));
    }

    //**** ИЗБРАННОЕ                 ******
    //**************** Избранное (ч/з Рефлексию) ************************
    public function addWishlist(WishlistItemInterface $wishlistItem)
    {
        try {
            $class = (new ReflectionClass($wishlistItem))->getShortName();
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            throw new \DomainException('Ошибка добавления в избранное. Попробуйте позже, когда мы устраним проблему');
        }
        $class = lcfirst($class) . 's';
        /** @var WishlistItemInterface[] $wishlist */
        $wishlist = $this->$class;
        foreach ($wishlist as $item) {
            if ($item->isFor($wishlistItem->getId())) {
                throw new \DomainException(Lang::t('Уже добавлено в избранное'));
            }
        }
        $wishlist[] = $wishlistItem;
        $this->$class = $wishlist;
    }

    public function removeWishlist(WishlistItemInterface $wishlistItem)
    {
        try {
            $class = (new ReflectionClass($wishlistItem))->getShortName();
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            throw new \DomainException('Ошибка добавления в избранное. Попробуйте позже, когда мы устраним проблему');
        }
        $class = lcfirst($class) . 's';
        /** @var WishlistItemInterface[] $wishlist */
        $wishlist = $this->$class;
        foreach ($wishlist as $i => &$item) {
            if ($item->isFor($wishlistItem->getId())) {
                $item->delete();
                unset($wishlist[$i]);
                $this->$class = $wishlist;
                return;
            }
        }
        throw new \DomainException(Lang::t('Избранное не найдено'));
    }

    /** getXX ===================> */
    public function getBookingTours(): ActiveQuery
    {
        return $this->hasMany(BookingTour::class, ['user_id' => 'id']);
    }

    public function getWishlistTours(): ActiveQuery
    {
        return $this->hasMany(WishlistTour::class, ['user_id' => 'id']);
    }

    public function getBookingCars(): ActiveQuery
    {
        return $this->hasMany(BookingCar::class, ['user_id' => 'id']);
    }

    public function getWishlistCars(): ActiveQuery
    {
        return $this->hasMany(WishlistCar::class, ['user_id' => 'id']);
    }

    public function getWishlistFuns(): ActiveQuery
    {
        return $this->hasMany(WishlistFun::class, ['user_id' => 'id']);
    }

    public function getWishlistStays(): ActiveQuery
    {
        return $this->hasMany(WishlistStay::class, ['user_id' => 'id']);
    }

    public function getWishlistFoods(): ActiveQuery
    {
        return $this->hasMany(WishlistFood::class, ['user_id' => 'id']);
    }

    public function getWishlistProducts(): ActiveQuery
    {
        return $this->hasMany(WishlistProduct::class, ['user_id' => 'id']);
    }

    public function getNetworks(): ActiveQuery
    {
        return $this->hasMany(Network::class, ['user_id' => 'id']);
    }

    public function getPersonal(): ActiveQuery
    {
        return $this->hasOne(Personal::class, ['user_id' => 'id']);
    }

    public function getPreferences(): ActiveQuery
    {
        return $this->hasOne(Preferences::class, ['user_id' => 'id']);
    }

    public function getMailing(): ActiveQuery
    {
        return $this->hasOne(UserMailing::class, ['user_id' => 'id']);
    }

    public function getForumsRead(): ActiveQuery
    {
        return $this->hasMany(ForumRead::class, ['user_id' => 'id']);
    }


    /** <=============== getXX*/

    /** Repository ===================> */

    public function setLang($lang)
    {
        $preferences = $this->preferences;
        $preferences->setLang($lang);
        $this->preferences = $preferences;
    }

    public function setCurrency($currency)
    {
        $preferences = $this->preferences;
        $preferences->setCurrency($currency);
        $this->preferences = $preferences;
    }

    /** Identity ===================> */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function removeVerificationToken()
    {
        $this->verification_token = null;
    }

    public function setForumRole(int $role)
    {
        $preferences = $this->preferences;
        $preferences->forum_role = $role;
        $this->preferences = $preferences;
    }


    /** <=============== Identity*/


}
