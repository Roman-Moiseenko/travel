<?php


namespace booking\entities\shops\products;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\entities\shops\products\queries\ProductQuery;
use booking\entities\shops\Shop;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property integer $deadline -- срок изготовления/отправки (не более)
 * @property integer $buys
 * @property integer $quantity
 *
 * Внешние связи
 * @property Shop $shop
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property MaterialAssign[] $materialAssign
 * @property Material[] $materials
 * @property ReviewProduct[] $reviews
 * @property Category $category
 *
 * @property int $id [int]
 * @property int $shop_id [int]
 * @property string $name [varchar(255)]
 * @property string $description
 * @property string $name_en [varchar(255)]
 * @property string $description_en
 * @property int $created_at [int]
 * @property int $weight [int]
 * @property string $article [varchar(255)]
 * @property string $collection [varchar(255)]
 * @property string $color [varchar(255)]
 * @property int $cost [int]
 * @property int $discount [int]
 * @property int $manufactured_id [int]
 * @property int $category_id [int]
 * @property bool $active [tinyint(1)]
 * @property string $size_json [json]
 * @property int $main_photo_id [int]
 * @property string $meta_json [json]
 * @property int $views [int]
 * @property int $updated_at [int]
 * @property string $rating [decimal(3,2)]
 * @property bool $sale_on
 */
class Product extends ActiveRecord
{

    /** @var $size Size */
    public $size;

    /** @var $meta Meta */
    public $meta;

    public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount,
                                  $deadline, $quantity/*, $sale_on*/): self
    {
        $product = new static();
        $product->name = $name;
        $product->name_en = $name_en;
        $product->description = $description;
        $product->description_en = $description_en;

        $product->weight = $weight;
        $product->size = $size;
        $product->article = $article;
        $product->collection = $collection;
        $product->color = $color;

        $product->manufactured_id = $manufactured_id;
        $product->category_id = $category_id;
        $product->cost = $cost;
        $product->discount = $discount ?? 0;

        $product->active = false;
        $product->created_at = time();

        $product->views = 0;
        $product->deadline = $deadline;
        $product->buys = 0;
        $product->quantity = $quantity ?? 0;
        //$product->sale_on = $sale_on;
        return $product;
    }

    public function edit($name, $name_en, $description, $description_en,
                         $weight, $size, $article, $collection, $color,
                         $manufactured_id, $category_id, $cost, $discount,
                         $deadline, $quantity): void
    {
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;

        $this->weight = $weight;
        $this->size = $size;
        $this->article = $article;
        $this->collection = $collection;
        $this->color = $color;

        $this->manufactured_id = $manufactured_id;
        $this->category_id = $category_id;
        $this->cost = $cost;
        $this->discount = $discount ?? 0;
        $this->quantity = $quantity ?? 0;

        $this->deadline = $deadline;
    }

    public function active(): void
    {
        $this->active = true;
    }

    public function draft(): void
    {
        $this->active = false;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function upViews()
    {
        $this->views++;
    }

    public function getBrand(): string
    {
        return $this->shop->getName();
    }

    public static function tableName()
    {
        return '{{%shops_product}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'materialAssign',
                    'reviews',
                    'photos',
                ],
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

    public function afterFind(): void
    {
        $size = Json::decode($this->getAttribute('size_json'));
        $this->size = Size::create(
            $size['width'] ?? null,
            $size['height'] ?? null,
            $size['depth'] ?? null,
            );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $size = $this->size;
        $this->setAttribute('size_json', Json::encode([
            'width' => $size->width,
            'height' => $size->height,
            'depth' => $size->depth,
        ]));

        return parent::beforeSave($insert);
    }
    public function clearMaterial()
    {
        $this->materialAssign = [];
    }

    public function assignMaterial($material)
    {
        $assign = $this->materialAssign;
        $assign[] = MaterialAssign::create($material);
        $this->materialAssign = $assign;
    }

    //====== Photo         ============================================

    public function addPhotoClass(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
    }

    public function addPhoto(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
        $this->updated_at = time();
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    protected function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    //********** Review        ********************************************

    public function addReview(BaseReview $review): BaseReview
    {
        $reviews = $this->reviews;
        $reviews[] = $review;
        $this->updateReviews($reviews);
        return $review;
    }

    public function editReview($id, $vote, $text): void
    {

        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $review->edit($vote, $text);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        /* @var BaseReview $review */
        foreach ($reviews as $review) {
            $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = $total / count($reviews);
    }

    //********** Внешние связи **********************

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewProduct::class, ['product_id' => 'id']);
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

    public function getMaterialAssign(): ActiveQuery
    {
        return $this->hasMany(MaterialAssign::class, ['product_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getMaterials(): ActiveQuery
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->via('materialAssign');
    }
    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    public function isAd(): bool
    {
        return $this->shop->isAd();
    }

    public function saleOn(): bool
    {
        if (!$this->shop->isAd()) return true;
        return $this->quantity > 0;
    }

    public function checkout($quantity)
    {
        if ($quantity  > $this->quantity)
            throw new \DomainException('Кол-во заказа превышает остатки на складе.');
        $this->quantity -= $quantity;
    }

    public function repair($quantity)
    {
        $this->quantity += $quantity;
    }
}