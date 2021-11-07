<?php


namespace booking\entities\touristic\fun;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\Type;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * Class Fun
 * @package booking\entities\booking\funs
 * @property integer $id
 * @property integer $category_id - Тип (entities)
 * @property string $name - Название
 * @property string $slug
 * @property string $description
 * @property integer $main_photo_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property float $rating
 * ====== GET-Ы ============================================
 * @property Category $category
 * @property Photo $mainPhoto
 * @property ReviewFun[] $reviews
 * @property Photo[] $photos
 * @property string $meta_json
 */
class Fun extends ActiveRecord
{

    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;


    public static function create($name, $description, $category_id, BookingAddress $address): self
    {
        $fun = new static();
        $fun->name = $name;
        $fun->description = $description;
        $fun->category_id = $category_id;
        $fun->address = $address;
        $fun->slug = SlugHelper::slug($name); //?
        $fun->created_at = time();
        $fun->status = StatusHelper::STATUS_INACTIVE;
        return $fun;
    }

    public function edit($name, $description, $category_id, BookingAddress $address): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->address = $address;
    }

    public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    public function activated()
    {
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function inactivated()
    {
        $this->status = StatusHelper::STATUS_INACTIVE;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%touristic_fun}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            BookingAddressBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'reviews',
                ],
            ],
        ];
    }

    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['fun_id' => 'id'])->orderBy('sort');
    }


    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getReviews(): ActiveQuery
    {
        /** Только активные отзывы */
        return $this->hasMany(ReviewFun::class, ['fun_id' => 'id'])->andWhere([ReviewFun::tableName() . '.status' => BaseReview::STATUS_ACTIVE]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getName(): string
    {
        return $this->name;
    }
}