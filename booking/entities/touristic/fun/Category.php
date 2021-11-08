<?php


namespace booking\entities\touristic\fun;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @package booking\entities\booking\funs
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property integer $sort
 * @property string $photo
 * @property Fun[] $funs
 * @property string $meta_json [json]
 * @mixin ImageUploadBehavior
 *
 */
class Category extends ActiveRecord
{

    /** @var $meta Meta */
    public $meta;

    public static function create($name, $slug, $description, $title): self
    {
        $category = new static();
        $category->name = $name;
        $category->description = $description;
        $category->title = $title;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        return $category;
    }

    public function edit($name, $slug, $description, $title): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->title = $title;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $this->slug = $slug;
    }

    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/touristic/fun/category/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/touristic/fun/category/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/touristic/fun/category/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/touristic/fun/category/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'c3' => ['width' => 900, 'height' => 300],
                    'c1' => ['width' => 300, 'height' => 300],
                    'c1r2' => ['width' => 300, 'height' => 600],
                    'c2' => ['width' => 600, 'height' => 300],
                    'mobile' => ['width' => 457, 'height' => 200],
                ],
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%touristic_fun_category}}';
    }

    public function getFuns(): ActiveQuery
    {
        return $this->hasMany(Fun::class, ['category_id' => 'id']);
    }

}