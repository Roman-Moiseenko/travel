<?php

namespace booking\entities\touristic\stay;

//use shop\services\WaterMarker;

use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

//use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $stay_id
 * @property string $alt [varchar(255)]
 * @property Stay $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'touristic/stay';
    protected $name_id = 'stay_id';

    public static function tableName(): string
    {
        return '{{%touristic_stay_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stay_id']);
    }

}