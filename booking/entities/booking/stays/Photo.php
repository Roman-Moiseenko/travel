<?php

namespace booking\entities\booking\stays;

use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

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
    protected $catalog = 'stays';
    protected $name_id = 'stay_id';

    public static function tableName(): string
    {
        return '{{%booking_stays_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stay_id']);
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