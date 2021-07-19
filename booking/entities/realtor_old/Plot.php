<?php


namespace booking\entities\realtor_old;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\land\Point;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;

/**
 * Class Plot
 * @package booking\entities\realtor
 * @property integer $id
 * @property integer $landowner_id
 * @property integer $created_at
 * @property integer $region_id
 * @property string $caption
 * @property integer $square
 * @property integer $cost
 * @property string $cadastre
 * @property NearbyAssignment[] $nearbyAssignments
 * @property integer $status
 */
class Plot extends ActiveRecord
{
    const DRAFT = 1;
    const SALE = 2;
    const SOLD = 3;

    /** @var $address BookingAddress */
    public $address;
    /** @var $points Point[]  */
    public $points = [];

    public static function create($caption, $square, $cost, $cadastre): self
    {
        $plot = new static();
        $plot->caption = $caption;
        $plot->square = $square;
        $plot->cost = $cost;
        $plot->cadastre = $cadastre;
        $plot->status = self::DRAFT;
        $plot->created_at = time();
        return $plot;
    }

    public function draft(): void
    {
        $this->status = self::DRAFT;
    }

    public function sale(): void
    {
        $this->status = self::SALE;
    }

    public function sold(): void
    {
        $this->status = self::SOLD;
    }

    public function isActive(): bool
    {
        return $this->status == self::SALE || $this->status == self::SOLD;
    }

    public function isSale(): bool
    {
        return $this->status == self::SALE;
    }

    public static function tableName()
    {
        return '{{%realtor_plots}}';
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'nearbyAssignments',
                ],
            ],
        ];
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub

        $points = json_decode($this->getAttribute('points_json'));
        foreach ($points as $point) {
            $this->points[] = Point::create($point->latitude, $point->longitude);
        }
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('points_json', json_encode($this->points));
        return parent::beforeSave($insert);
    }
}