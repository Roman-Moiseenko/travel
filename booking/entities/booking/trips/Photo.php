<?php

namespace booking\entities\booking\trips;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $tours_id
 * @property string $alt
 * @property Trip $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'trips';
    protected $name_id = 'trips_id';

    public static function tableName(): string
    {
        return '{{%booking_trips_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Trip::class, ['id' => 'trips_id']);
    }

}