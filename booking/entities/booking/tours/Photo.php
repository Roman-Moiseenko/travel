<?php

namespace booking\entities\booking\tours;

//use shop\services\WaterMarker;

use booking\entities\booking\BasePhoto;
use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

//use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $tours_id
 * @property string $alt
 * @property Tour $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'tours';
    protected $name_id = 'tours_id';

    public static function tableName(): string
    {
        return '{{%booking_tours_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tours_id']);
    }

}