<?php

namespace booking\entities\events;

use booking\helpers\BookingHelper;
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
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property integer $admin_id
 * @property string $fullname
 * @property string $box_office
 * @property string $phone
 * @property BookingObject[] $objects
 * property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    public static function create(
        $admin_id,
        $username, $password,
        $fullname, $box_office, $phone
    ): self
    {
        $user = new static();
        $user->admin_id = $admin_id;
        $user->username = $username;
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->status = self::STATUS_ACTIVE;
        $user->created_at = time();
        $user->fullname = $fullname;
        $user->box_office = $box_office;
        $user->phone = $phone;
        $user->generateAuthKey();
        return $user;
    }

    public function edit($username, $password,
                         $fullname, $box_office, $phone): void
    {
        $this->username = $username;
        if (!empty($password)) $this->setPassword($password);
        $this->fullname = $fullname;
        $this->box_office = $box_office;
        $this->phone = $phone;
        $this->updated_at = time();
    }

    public function addObject($object_type, $object_id)
    {
        $objects = $this->objects;
        //Проверка на существование
        foreach ($objects as $i => $object) {
            if ($object->exist($object_type, $object_id))
                throw new  \DomainException('Уже добавлен такой объект');
        }
        $object = BookingObject::create($object_type, $object_id);
        $objects[] = $object;
        $this->objects = $objects;
    }

    public function removeObject($object_type, $object_id)
    {
        $objects = $this->objects;
        foreach ($objects as $i => $object) {
            if ($object->exist($object_type, $object_id)) {
                unset($objects[$i]);
                $this->objects = $objects;
                return;
            }
        }
        throw new \DomainException('Не найден объект ' . BookingHelper::LIST_TYPE[$object_type] . ' ID=' . $object_id);
    }

    public function existObject($object_type, $object_id): bool
    {
        $objects = $this->objects;
        foreach ($objects as $object) {
            if ($object->exist($object_type, $object_id)) {
                return true;
            }
        }
        return false;
    }

    public function Inactive(): void
    {
        $this->status = self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getObjects(): ActiveQuery
    {
        return $this->hasMany(BookingObject::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_users}}';
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
                'relations' => ['objects'],
            ],
        ];
    }


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
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

    public function isFor($check_user_id): bool
    {
        return $this->id == $check_user_id;
    }

    /** <=============== Identity*/


}
