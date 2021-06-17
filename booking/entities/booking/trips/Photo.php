<?php

namespace booking\entities\booking\trips;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property string $alt
 * @property Trip $main
 * @property int $trip_id [int]
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'trips';
    protected $name_id = 'trip_id';

    public static function tableName(): string
    {
        return '{{%booking_trips_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }

}