<?php


namespace booking\entities\booking;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property string $alt
 * @mixin ImageUploadBehavior
 */

abstract class BasePhoto extends ActiveRecord
{
    protected $catalog;
    protected $name_id;

    final public static function create(UploadedFile $file): self
    {
        $photo = new static();
        if (empty($photo->catalog) || empty($photo->name_id))
            throw new \DomainException('Ошибка определения класса - ' . get_class($photo));
        $photo->file = $file;
        return $photo;
    }

    abstract public function getMain(): ActiveQuery;

    public function getName(): string
    {
        return $this->main->getName();
    }

    public function getDescription(): string
    {
        return $this->main->description;
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

    public function getAlt():? string
    {
        return $this->alt;
    }

    final public function behaviors(): array
    {
        if (empty($this->catalog)) throw new \DomainException('Ошибка объявления наследника класса BasePhoto');
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/' . $this->catalog . '/[[attribute_' . $this->name_id . ']]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/' . $this->catalog . '/[[attribute_' . $this->name_id . ']]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/' . $this->catalog . '/[[attribute_' . $this->name_id . ']]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/' . $this->catalog . '/[[attribute_' . $this->name_id . ']]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'list' => ['width' => 150, 'height' => 150],
                    'top_widget_list'=> ['width' => 30, 'height' => 30],
                    'widget_list' => ['width' => 57, 'height' => 57],
                    'cabinet_list' => ['width' => 70, 'height' => 70],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_list_2x' => ['width' => 456, 'height' => 228],
                    'catalog_list_3x' => ['width' => 342, 'height' => 114],
                    'catalog_list_food' => ['width' => 300, 'height' => 200],
                    'catalog_list_mobile' => ['width' => 320, 'height' => 160],
                    'legal_list' => ['width' => 300, 'height' => 300],
                    'catalog_gallery' => ['width' => 800, 'height' => 400],
                    'catalog_gallery_3x' => ['width' => 900, 'height' => 300],
                    'catalog_gallery_mini' => ['width' => 400, 'height' => 200],
                    'catalog_main_mobil' => ['width' => 600, 'height' => 200],
                    'catalog_origin' => ['width' => 1080, 'height' => 720],
                    'map' => ['width' => 195, 'height' => 150],
                ],
            ],
        ];
    }
}