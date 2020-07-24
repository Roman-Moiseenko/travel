<?php

namespace booking\entities\booking\tours;

//use shop\services\WaterMarker;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

//use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $tours_id
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

    public static function tableName(): string
    {
        return '{{%booking_tours_photos}}';
    }

   public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/tours/[[attribute_tours_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/tours/[[attribute_tours_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/tours/[[attribute_tours_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/tours/[[attribute_tours_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'tours_list' => ['width' => 150, 'height' => 150],
                    'tours_widget_list' => ['width' => 57, 'height' => 57],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                   // 'catalog_stays_main' => [/*'width' => 750, 'height' => 500], //*/'processor' => [new WaterMarker(750, 500, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_tours_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['width' => 1024, 'height' => 768],
                ],
            ],
        ];
    }
}