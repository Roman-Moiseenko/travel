<?php


namespace booking\entities\booking\stays\nearby;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Nearby
 * @package booking\entities\booking\stays\nearby
 * @property integer $id
 * @property integer $stay_id
 * @property string $name
 * @property integer $distance
 * @property integer $category_id
 * @property NearbyCategory $category
 */
class Nearby extends ActiveRecord
{


    public static function tableName()
    {
        return '{{%booking_stays_nearby}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(NearbyCategory::class, ['id' => 'category_id']);
    }

}