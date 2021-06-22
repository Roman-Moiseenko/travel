<?php


namespace booking\entities\booking\trips;


use booking\entities\booking\BaseVideo;
use yii\db\ActiveRecord;

/**
 * Class Video
 * @package booking\entities\booking\trips
 * @property integer $id
 * @property integer $trip_id
 * @property string $caption
 * @property integer $created_at
 * @property string $url
 * @property integer $type_hosting
 * @property integer $sort
 */
class Video extends BaseVideo
{

    public static function tableName()
    {
        return '{{%booking_trips_videos}}';
    }
}