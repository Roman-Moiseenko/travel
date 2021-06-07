<?php

namespace booking\entities\vmuseum;

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
 * @property integer $vmuseum_id
 * @property string $alt
 * @property VMuseum $vmuseum
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'vmuseum';
    protected $name_id = 'vmuseum_id';

    public static function tableName(): string
    {
        return '{{%vmuseum_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(VMuseum::class, ['id' => 'vmuseum_id']);
    }

}