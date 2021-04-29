<?php


namespace booking\entities\shops\products;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\entities\queries\CategoryQuery;
use booking\helpers\SlugHelper;
use booking\services\WaterMarker;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 * @property string $photo
 * @property string $meta_json [json]
 * @mixin NestedSetsBehavior
 * @mixin ImageUploadBehavior
 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $title, $description, Meta $meta)
    {
        $this->name = $name;
        if (empty($slug)) {
            $slug = SlugHelper::slug($name);
        }
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%shops_product_category}}';
    }

    public function getSeoTile(): string
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile(): string
    {
        return $this->title ?: $this->name;
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/shop_category/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/shop_category/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/shop_category/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/shop_category/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'category' => ['width' => 100, 'height' => 100],
                    /*'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 1000, 'height' => 150],
                    'landing_list' => ['width' => 300, 'height' => 400],
                    'widget_list' => ['width' => 228, 'height' => 228],
                    'widget_top' => ['width' => 1000, 'height' => 150],
                    'widget_mobile' => ['width' => 300, 'height' => 100],
                    'widget_bottom' => ['width' => 300, 'height' => 150],*/
                    //'origin' => ['processor' => [new WaterMarker(1024, 768, '@static/files/images/logo-mail.png'), 'process']],
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

}