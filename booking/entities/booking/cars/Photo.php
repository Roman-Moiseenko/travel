<?php

namespace booking\entities\booking\cars;

//use shop\services\WaterMarker;

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
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public static function tableName(): string
    {
        return '{{%booking_cars_photos}}';
    }

   public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/cars/[[attribute_car_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/cars/[[attribute_car_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/cars/[[attribute_car_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/cars/[[attribute_car_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'cars_list' => ['width' => 150, 'height' => 150],
                    'top_widget_list'=> ['width' => 30, 'height' => 30],
                    'cars_widget_list' => ['width' => 57, 'height' => 57],
                    'cabinet_list' => ['width' => 70, 'height' => 70],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'legal_list' => ['width' => 300, 'height' => 300],
                    'catalog_cars_main' => ['width' => 1200, 'height' => 400], //*/'processor' => [new WaterMarker(750, 500, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_cars_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['width' => 1024, 'height' => 768],
                ],
            ],
        ];
    }
}