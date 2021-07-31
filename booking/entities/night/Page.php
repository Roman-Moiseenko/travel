<?php


namespace booking\entities\night;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BaseReview;
use booking\entities\Meta;
use booking\entities\queries\CategoryQuery;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use paulzi\nestedsets\NestedSetsBehavior;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $title
 * @property string $photo
 * @property string $slug
 * @property string $content
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 *
 * @property Page $parent
 * @property Page[] $parents
 * @property Page[] $children
 * @property Page $prev
 * @property Page $next
 * @property string $meta_json [json]
 * @property string $icon
 * @property ReviewNight[] $reviews
 * @property string $name [varchar(255)]
 * @mixin NestedSetsBehavior
 * @mixin ImageUploadBehavior
 */
class Page extends ActiveRecord
{
    public $meta;

    public static function create($name, $title, $slug, $content, Meta $meta, $icon, $description): self
    {
        $page = new static();
        $page->title = $title;
        $page->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($title);
        $page->slug = $slug;
        $page->content = $content;
        $page->description = $description;
        $page->meta = $meta;
        $page->icon = $icon;
        return $page;
    }

    public function edit($name, $title, $slug, $content, Meta $meta, $icon, $description)
    {
        $this->name = $name;
        $this->title = $title;
        if (empty($slug)) {
            $slug = SlugHelper::slug($title);
        }
        $this->slug = $slug;
        $this->content = $content;
        $this->description = $description;
        $this->meta = $meta;
        $this->icon = $icon;
    }
    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }
    public static function tableName()
    {
        return '{{%night_pages}}';
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'reviews'
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/night/pages/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/night/pages/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/night/pages/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/night/pages/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 100],
                    'cart_list' => ['width' => 140, 'height' => 250],
                    'cart_list_2' => ['width' => 140, 'height' => 140],
                    'button_image' => ['width' => 400, 'height' => 600],
                    'button_image_mobile' => ['width' => 300, 'height' => 300],
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

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewNight::class, ['page_id' => 'id']);
    }

    public function addReview(ReviewNight $review)
    {
        $reviews = $this->reviews;
        $reviews[] = $review;
        $this->reviews = $reviews;
        return $review;
    }

    public function removeReview($id)
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->reviews = $reviews;
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }
}