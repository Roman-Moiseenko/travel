<?php

namespace booking\entities\booking\trips\placement\room;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property string $alt
 * @property Room $main
 * @property int $room_id [int]
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'placements_room';
    protected $name_id = 'room_id';

    public static function tableName(): string
    {
        return '{{%booking_trips_placement_room_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Room::class, ['id' => 'room_id']);
    }

}