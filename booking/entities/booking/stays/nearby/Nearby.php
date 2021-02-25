<?php


namespace booking\entities\booking\stays\nearby;


use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Nearby
 * @package booking\entities\booking\stays\nearby
 * @property integer $id
 * @property integer $stay_id
 * @property string $name
 * @property integer $distance
 * @property string $unit
 * @property integer $category_id
 * @property NearbyCategory $category
 */
class Nearby extends ActiveRecord
{
    public static function create($name, $distance, $category_id, $unit): self
    {
        $nearby = new static();
        $nearby->name = $name;
        $nearby->distance = $distance;
        $nearby->category_id = $category_id;
        $nearby->unit = $unit;
        return $nearby;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_nearby}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(NearbyCategory::class, ['id' => 'category_id']);
    }

}