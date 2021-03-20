<?php

namespace booking\entities\booking\funs;

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
    protected $catalog = 'funs';
    protected $name_id = 'fun_id';

    public static function create(UploadedFile $file): BasePhoto
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public static function tableName(): string
    {
        return '{{%booking_funs_photos}}';
    }

   public function behaviors(): array
    {
        return parent::behaviors();
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

    public function getName(): string
    {
        return $this->main->getName();
    }

    public function getDescription(): string
    {
        return $this->main->getDescription();
    }
}