<?php

namespace booking\entities\booking\trips\activity;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property string $alt
 * @property Activity $main
 * @property int $activity_id [int]
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'activities';
    protected $name_id = 'activity_id';

    public static function tableName(): string
    {
        return '{{%booking_trips_activity_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Activity::class, ['id' => '$activity_id']);
    }

}