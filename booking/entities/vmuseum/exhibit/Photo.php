<?php

namespace booking\entities\vmuseum\exhibit;

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
 * @property integer $exhibit_id
 * @property string $alt
 * @property Exhibit $exhibit
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'exhibit';
    protected $name_id = 'exhibit_id';

    public static function tableName(): string
    {
        return '{{%vmuseum_exhibit_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Exhibit::class, ['id' => 'exhibit_id']);
    }

}