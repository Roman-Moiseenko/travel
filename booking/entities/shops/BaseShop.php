<?php


namespace booking\entities\shops;


use booking\ActivateObjectInterface;
use booking\entities\admin\Contact;
use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BaseReview;
use booking\entities\WorkMode;
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
 * @property User $user
 * @property Legal $legal
 *********************************** Скрытые поля
 */

abstract class BaseShop extends ActiveRecord implements ActivateObjectInterface
{

    public function __construct($user_id = null, $legal_id = null, $name = null, $name_en = null, $description = null, $description_en = null, $type_id = null, $config = [])
    {
        parent::__construct($config);
        if ($user_id) {
            $this->created_at = time();
            $this->user_id = $user_id;
            $this->legal_id = $legal_id;
            $this->name = $name;
            $this->name_en = $name_en;
            $this->description = $description;
            $this->description_en = $description_en;
            $this->type_id = $type_id;
            $this->status = StatusHelper::STATUS_INACTIVE;
        }
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

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

     public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    //**************** is ****************************
     public function isNew(): bool
    {
        if ($this->created_at == null) return false;
        return (time() - $this->created_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

     public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

     public function isVerify(): bool
    {
        return $this->status === StatusHelper::STATUS_VERIFY;
    }

     public function isDraft(): bool
    {
        return $this->status === StatusHelper::STATUS_DRAFT;
    }

     public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

     public function isLock()
    {
        return $this->status === StatusHelper::STATUS_LOCK;
    }

    abstract public function isAd(): bool;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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


    //====== Внешние связи        ============================================


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