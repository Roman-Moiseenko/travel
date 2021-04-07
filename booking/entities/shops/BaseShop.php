<?php


namespace booking\entities\shops;


use booking\ActivateObjectInterface;
use booking\entities\admin\Contact;
use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BaseReview;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Lang;
use booking\entities\queries\ObjectActiveQuery;
use booking\entities\shops\products\BaseProduct;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Shop
 * @package booking\entities\shops
 * @property integer $id
 * @property integer $user_id
 * @property integer $legal_id
 * @property integer $public_at
 * @property int $type_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name

 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property float $rating
 * @property integer $status

 ********************************* Внешние связи
 * @property BaseProduct[] $products
 * @property BaseReview[] $reviews
 * @property User $user
 * @property Legal $legal
 *********************************** Скрытые поля
 */

abstract class BaseShop extends ActiveRecord implements ActivateObjectInterface
{

    public static function create($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id): self
    {
        $shop = new static();
        $shop->created_at = time();
        $shop->user_id = $user_id;
        $shop->legal_id = $legal_id;
        $shop->name = $name;
        $shop->name_en = $name_en;
        $shop->description = $description;
        $shop->description_en = $description_en;
        $shop->type_id = $type_id;
        $shop->status = StatusHelper::STATUS_INACTIVE;
        return $shop;
    }

    public function edit($legal_id, $name, $name_en, $description, $description_en, $type_id): void
    {
        $this->legal_id = $legal_id;
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;
        $this->type_id = $type_id;
    }


    //**************** Set ****************************

    public function setStatus($status)
    {
        $this->status = $status;
    }

    //**************** Get ****************************

    final public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    final public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    //**************** is ****************************
    final public function isNew(): bool
    {
        if ($this->created_at == null) return false;
        return (time() - $this->created_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    final public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    final public function isVerify(): bool
    {
        return $this->status === StatusHelper::STATUS_VERIFY;
    }

    final public function isDraft(): bool
    {
        return $this->status === StatusHelper::STATUS_DRAFT;
    }

    final public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    final public function isLock()
    {
        return $this->status === StatusHelper::STATUS_LOCK;
    }

    abstract public function isAd(): bool;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'reviews',
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    //**************** Product ****************************

    public function addProduct(BaseProduct $product)
    {

    }

    public function updateProduct(BaseProduct $product)
    {

    }

    public function removeProduct($id)
   {

   }

    //====== Review        ============================================

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

    public function countReviews(): int
    {
        $reviews = $this->reviews;
        return count($reviews);
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
    //====== Внешние связи        ============================================

    abstract public function getReviews(): ActiveQuery;
    abstract public function getProducts(): ActiveQuery;

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public static function find(): ObjectActiveQuery
    {
        return new ObjectActiveQuery(static::class);
    }
}