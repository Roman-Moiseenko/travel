<?php


namespace booking\entities\shops\products;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\Lang;
use booking\entities\Meta;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property integer $id
 * @property integer $shop_id
 * @property string $name
 * @property string $description
 * @property string $name_en
 * @property string $description_en
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $weight - вес
 * @property string $article - артикул
 * @property string $collection - колекция/серия
 * @property string $color - цвет
 * @property integer $cost - цена
 * @property integer $discount - скидка для текущего товара
 * @property integer $manufactured_id - тип производства
 * @property integer $category_id - категория (вид изделия)
 * @property bool $active
 * @property Size $size - размер
 * @property string $size_json
 * @property integer $main_photo_id
 *
 * @property string $meta_json
 * @property BasePhoto $mainPhoto
 * @property BasePhoto[] $photos
 * @property BaseReview[] $reviews
 * @property Category $category
 * @property BaseMaterialAssign[] $materialAssign
 */
abstract class BaseProduct extends ActiveRecord
{
    /** @var $size Size */
    public $size;

    /** @var $meta Meta */
    public $meta;

    public function __construct($name = null, $name_en = null, $description = null, $description_en = null,
                                $weight = null, Size $size = null, $article = null, $collection = null, $color = null,
                                $manufactured_id = null, $category_id = null, $cost = null, $discount = null,
        $config = [])
    {
        parent::__construct($config);
        if ($name) {
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
            $this->discount = $discount;

            $this->active = false;
            $this->created_at = time();
        }
    }

  /*  public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount): self
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
        $product->discount = $discount;

        $product->active = false;
        $product->created_at = time();

        return $product;
        //Во view при создании проверяетс тип магазина и заполняется $manufactured_id
    }*/

    final public function active(): void
    {
        $this->active = true;
    }

    final public function draft(): void
    {
        $this->active = false;
    }

    final public function isActive(): bool
    {
        return $this->active;
    }

    final public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    final public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    final public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
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


    //********** Внешние связи **********************
    abstract public function getPhotos(): ActiveQuery;

    abstract public function getMainPhoto(): ActiveQuery;

    abstract public function getReviews(): ActiveQuery;

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getMaterialAssign(): ActiveQuery
    {
        return $this->hasMany(MaterialAssign::class, ['product_id' => 'id']);
    }

    public function getMaterials(): ActiveQuery
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->via('materialAssign');
    }
}