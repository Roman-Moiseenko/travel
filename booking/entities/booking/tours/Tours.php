<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\Geo;
use yii\db\ActiveRecord;

/**
 * Class Tours
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $status
 * @property string $discription
 * @property BookingAddress $address
 */
class Tours extends ActiveRecord
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    public $address;
    public $geo;
    public static function create(): self
    {
        $tours = new static();

        return $tours;
    }


    public
    static function tableName()
    {
        return '{{%booking_tours}}';
    }
    public function afterFind(): void
    {

        $this->address = new BookingAddress(
            $this->getAttribute('town'),
            $this->getAttribute('street'),
            $this->getAttribute('house'),
        );

        $this->geo = new Geo(
            $this->getAttribute('latitude'),
            $this->getAttribute('longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('town', $this->address->town);
        $this->setAttribute('street', $this->address->street);
        $this->setAttribute('house', $this->address->house);

        $this->setAttribute('latitude', $this->geo->latitude);
        $this->setAttribute('longitude', $this->geo->longitude);

        return parent::beforeSave($insert);
    }

}