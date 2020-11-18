<?php


namespace booking\entities\check;


use booking\helpers\BookingHelper;
use yii\db\ActiveRecord;

/**
 * Class BookingObject
 * @package booking\entities\check
 * @property integer $id
 * @property integer $user_id
 * @property string $object_type
 * @property integer $object_id
 */

class BookingObject extends ActiveRecord
{

    public static function create($object_type, $object_id): self
    {
        $object = new static();
        $object->object_type = $object_type;
        $object->object_id = $object_id;
        return $object;
    }

    public function isFor($id): bool
    {
        return $this->id === $id;
    }

    public function exist($object_type, $object_id): bool
    {
        return ($this->object_type == $object_type) && ($this->object_id == $object_id);
    }

    public static function tableName()
    {
        return '{{%check_users_booking_objects}}';
    }

    public function classObject(): string
    {
        return BookingHelper::LIST_TYPE[$this->object_type];
    }

    public function classBooking(): string
    {
        return BookingHelper::LIST_BOOKING_TYPE[$this->object_type];
    }
}