<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\Geo;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Tours
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $main_photo_id
 * @property integer $status
 * @property string $discription
 * @property integer type_id
 * @property BookingAddress $address
 * @property Extra[] $extra
 * @property Review[] $reviews
 * @property ToursType $type
 * @property ToursParams $params
 * @property Photo[] $photos
 * @property Cost $baseCost
 */
class Tours extends ActiveRecord
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    public $address;
    public $cost;
    public $params;
    public $baseCost;

    public static function create($name, $type_id, $description, BookingAddress $address, ToursParams $params): self
    {
        $tours = new static();
        $tours->created_at = time();
        $tours->status = Tours::STATUS_INACTIVE;


        return $tours;
    }

    public function setLegal($legalId)
    {
        $this->legal_id = $legalId;
    }


    public static function tableName()
    {
        return '{{%booking_tours}}';
    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_town'),
            $this->getAttribute('adr_street'),
            $this->getAttribute('adr_house'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('adr_town', $this->address->town);
        $this->setAttribute('adr_street', $this->address->street);
        $this->setAttribute('adr_house', $this->address->house);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);
        return parent::beforeSave($insert);
    }

    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getExtra(): ActiveQuery
    {
        return $this->hasMany(Extra::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(ToursType::class, ['id' => 'type_id']);
    }

    /** <========== getXXX */
}