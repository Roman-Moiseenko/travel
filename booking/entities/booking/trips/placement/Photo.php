<?php

namespace booking\entities\booking\trips\placement;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property string $alt
 * @property Placement $main
 * @property int $placement_id [int]
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'placements';
    protected $name_id = 'placement_id';

    public static function tableName(): string
    {
        return '{{%booking_trips_placement_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Placement::class, ['id' => 'placement_id']);
    }

}