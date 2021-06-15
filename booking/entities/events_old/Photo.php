<?php

namespace booking\entities\events;

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
 * @property integer provider_id
 * @property string $alt
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'provider';
    protected $name_id = 'provider_id';

    public static function tableName(): string
    {
        return '{{%provider_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Provider::class, ['id' => 'provider_id']);
    }

}