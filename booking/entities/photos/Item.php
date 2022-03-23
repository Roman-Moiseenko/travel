<?php
declare(strict_types=1);

namespace booking\entities\photos;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $page_id
 * @property string $photo
 * @property string $name
 * @property string $description
 * @property integer $sort
 * @mixin ImageUploadBehavior
 */
class Item extends ActiveRecord
{
    public static function create(string $name, string $description, UploadedFile $photo = null): self
    {
        $item = new static();
        $item->name = $name;
        $item->description = $description;
        if (!empty($photo)) $item->photo = $photo;
        return $item;
    }

    public function edit(string $name, string $description, UploadedFile $photo = null): void
    {
        $this->name = $name;
        $this->description = $description;
        if (!empty($photo)) $this->photo = $photo;
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%photos_page_items}}';
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/photos_blog/[[attribute_page_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/photos_blog/[[attribute_page_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/photos_blog/[[attribute_page_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/photos_blog/[[attribute_page_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'list' => ['width' => 150, 'height' => 150],
                    'top_widget_list' => ['width' => 30, 'height' => 30],
                    'widget_list' => ['width' => 57, 'height' => 57],
                    'cabinet_list' => ['width' => 70, 'height' => 70],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_list_2x' => ['width' => 456, 'height' => 228],
                    'catalog_list_3x' => ['width' => 342, 'height' => 114],
                    'catalog_list_mobile' => ['width' => 320, 'height' => 160],
                    'legal_list' => ['width' => 300, 'height' => 300],
                    'catalog_gallery' => ['width' => 800, 'height' => 400],
                    'catalog_gallery_3x' => ['width' => 900, 'height' => 300],
                    'catalog_gallery_mini' => ['width' => 400, 'height' => 200],
                    'catalog_main_mobil' => ['width' => 600, 'height' => 200],
                    'catalog_origin' => ['width' => 1080, 'height' => 720],
                ],
            ],
        ];
    }
}