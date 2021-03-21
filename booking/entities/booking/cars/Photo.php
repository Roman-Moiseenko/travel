<?php

namespace booking\entities\booking\cars;

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
 * @property integer $car_id
 * @property string $alt [varchar(255)]
 * @property Car $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'cars';
    protected $name_id = 'car_id';

    public static function tableName(): string
    {
        return '{{%booking_cars_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
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