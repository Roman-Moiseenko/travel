<?php

namespace booking\entities\touristic\fun;

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
 * @property integer $fun_id
 * @property string $alt [varchar(255)]
 * @property Fun $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'touristic/fun';
    protected $name_id = 'fun_id';

    public static function tableName(): string
    {
        return '{{%touristic_fun_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

}