<?php
namespace booking\entities\admin;

use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\services\Capacity;
use booking\entities\booking\tours\services\Transfer;
use booking\entities\booking\tours\Tour;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use booking\helpers\StatusHelper;
use Yii;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
 * @property integer $created_at
 * @property integer $updated_at
 * @property Legal[] $legals
 * @property Personal $personal
 * @property Notice $notice
 * @property Preferences $preferences
 * @property ForumRead[] $forumsRead
 * @property Deposit[] $deposit
 * @property Debiting[] $debiting
 * @property Capacity[] $tourCapacities
 * @property Transfer[] $tourTransfers
 * property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_LOCK = 0;
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
        $user->personal = Personal::create('', null, new UserAddress(), new FullName(), '', false);
        $user->notice = Notice::create();
        $user->preferences = Preferences::create();
        return $user;
    }

    public function edit(string $username, string $email): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->updated_at = time();
    }

    public static function signup(string $username, string $email, string $password): self
    {
        $user = User::create($username, $email, $password);
        $user->status = self::STATUS_INACTIVE;
        $user->generateEmailVerificationToken();
        return $user;
    }

    //********* Transfer **************
    public function addTransfer(Transfer $transfer): void
    {
        $transfers = $this->tourTransfers;
        $transfers[] = $transfer;
        $this->tourTransfers = $transfers;
    }

    public function removeTransfer($id): void
    {
        $transfers = $this->tourTransfers;
        foreach ($transfers as $i => $transfer) {
            if ($transfer->isFor($id)) {
                unset($transfers[$i]);
                $this->tourTransfers = $transfers;
                return;
            }
        }
        throw new \DomainException('Неверный id Трансфера ' . $id);
    }
    public function costTransfer($id, $cost): void
    {
        $transfers = $this->tourTransfers;
        foreach ($transfers as $i => &$transfer) {
            if ($transfer->isFor($id)) {
                $transfer->setCost($cost);
                $this->tourTransfers = $transfers;
                return;
            }
        }
        throw new \DomainException('Неверный id Трансфера ' . $id);
    }

    //********* Capacity **************

    public function addCapacity(Capacity $capacity): void
    {
        $capacities = $this->tourCapacities;
        $capacities[] = $capacity;
        $this->tourCapacities = $capacities;
    }

    public function removeCapacity($id): void
    {
        $capacities = $this->tourCapacities;
        foreach ($capacities as $i => $capacity) {
            if ($capacity->isFor($id)) {
                unset($capacities[$i]);
                $this->tourCapacities = $capacities;
                return;
            }
        }
        throw new \DomainException('Неверный id Вместительности ' . $id);
    }


    //********* Balance ***************

    public function Balance(): float
    {
        $deposit = $this->deposit;
        $debiting = $this->debiting;
        $amount_deposit = 0;
        $amount_debiting = 0;
        foreach ($deposit as $item) {
            $amount_deposit += $item->amount;
        }
        foreach ($debiting as $item) {
            $amount_debiting += $item->amount;
        }
        return $amount_deposit - $amount_debiting;
    }

    public function newDeposit(Deposit $newDeposit): void
    {
        $deposit = $this->deposit;
        $deposit[] = $newDeposit;
        $this->deposit = $newDeposit;
    }

    public function newDebiting(Debiting $newDebiting): void
    {
        $debiting = $this->debiting;
        $debiting[] = $newDebiting;
        $this->debiting = $debiting;
    }

    public function updatePersonal(Personal $personal)
    {
        $this->personal = $personal;
    }

    public function updateNotice(Notice $notice)
    {
        $this->notice = $notice;
    }

    public function UpdatePreferences(Preferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public function addLegal(Legal $legal)
    {
        $legals = $this->legals;
        $legals[] = $legal;
        $this->legals = $legals;
    }

    public function updateLegal($id, Legal $legal_new)
    {
        $legals = $this->legals;
        foreach ($legals as $i => $legal) {
            if ($legal->isFor($id)) {
                $legals[$i] = $legal_new;
                $this->legals = $legals;
                return;
            }
        }
        throw new \DomainException('Фирма не найдена');
    }

    public function removeLegal($id)
    {
        $legals = $this->legals;
        foreach ($legals as $i => $legal) {
            if ($legal->isFor($id)) {
                unset($legals[$i]);
                $this->legals = $legals;
                return;
            }
        }
        throw new \DomainException('Фирма не найдена');
    }

    public function isActive(): bool
    {
        if ($this->status === self::STATUS_ACTIVE) return true;
        return false;
    }

    public function isInactive(): bool
    {
        if ($this->status === self::STATUS_INACTIVE) return true;
        return false;
    }

    public function isLock(): bool
    {
        if ($this->status === self::STATUS_LOCK) return true;
        return false;
    }

    /** ============= Forum Read  */
    /** @var $post_id integer */
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

    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Пароль уже был сброшен');
        }
        $this->generatePasswordResetToken();
    }

    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Сброшенный пароль не подтвержден');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'personal',
                    'legals',
                    'notice',
                    'preferences',
                    'forumsRead',
                    'deposit',
                    'debiting',
                    'tourCapacities',
                    'tourTransfers',
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

    /** Repository ===================> */

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
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

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }


//*********** Интерфейс User *************************

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public function removeVerificationToken()
    {
        $this->verification_token = null;
    }

    //******** Внешние связи **********************************
    public function getLegals(): ActiveQuery
    {
        return $this->hasMany(Legal::class, ['user_id' => 'id']);
    }

    public function getLegal($id): Legal
    {
        $legals = $this->legals;
        foreach ($legals as $legal) {
            if ($legal->isFor($id)) return $legal;
        }
        throw new \DomainException('Not Founded legal by $id = ' . $id);
    }

    public function getPersonal(): ActiveQuery
    {
        return $this->hasOne(Personal::class, ['user_id' => 'id']);
    }

    public function getNotice(): ActiveQuery
    {
        return $this->hasOne(Notice::class, ['user_id' => 'id']);
    }

    //TODO ** BOOKING_OBJECT **

    public function getTours(): ActiveQuery
    {
        return $this->hasMany(Tour::class, ['user_id' => 'id'])->andWhere(['status' => StatusHelper::STATUS_ACTIVE]);
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasMany(Stay::class, ['user_id' => 'id'])->andWhere(['status' => StatusHelper::STATUS_ACTIVE]);
    }

    public function getCars(): ActiveQuery
    {
        return $this->hasMany(Car::class, ['user_id' => 'id'])->andWhere(['status' => StatusHelper::STATUS_ACTIVE]);
    }

    public function getFuns(): ActiveQuery
    {
        return $this->hasMany(Fun::class, ['user_id' => 'id'])->andWhere(['status' => StatusHelper::STATUS_ACTIVE]);
    }

    public function getPreferences(): ActiveQuery
    {
        return $this->hasOne(Preferences::class, ['user_id' => 'id']);
    }

    public function getForumsRead(): ActiveQuery
    {
        return $this->hasMany(ForumRead::class, ['user_id' => 'id']);
    }

    public function getDeposit(): ActiveQuery
    {
        return $this->hasMany(Deposit::class, ['user_id' => 'id']);
    }

    public function getDebiting(): ActiveQuery
    {
        return $this->hasMany(Debiting::class, ['user_id' => 'id']);
    }

    public function sendSMS($phone, $message)
    {
        //TODO !!Сохранить в таблице отправленных СМС новую. Для отчетности!!!!
    }

    public function setForumRole(int $role)
    {
        $preferences = $this->preferences;
        $preferences->forum_role = $role;
        $this->preferences = $preferences;
    }

    public function getTourCapacities(): ActiveQuery
    {
        return $this->hasMany(Capacity::class, ['user_id' => 'id'])->orderBy(['count' => SORT_ASC]);
    }

    public function getTourTransfers(): ActiveQuery
    {
        return $this->hasMany(Transfer::class, ['user_id' => 'id']);//->orderBy(['count' => SORT_ASC]);
    }
}
