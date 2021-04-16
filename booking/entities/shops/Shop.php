<?php


namespace booking\entities\shops;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Product;
use booking\helpers\BookingHelper;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Shop
 * @package booking\entities\shops
 ********************************* Внешние связи
 * @property Product[] $products
 *
 *********************************** Скрытые поля
 * @property string $delivery_json
 */
class Shop extends BaseShop
{
    /** @var $delivery Delivery */
    public $delivery;

    public static function create($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id): Shop
    {
        $shop = new static($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id);
        $shop->delivery = new Delivery();
        return $shop;
    }

    public function setDelivery(Delivery $delivery): void
    {
        $this->delivery = $delivery;
    }

    public function isAd(): bool
    {
        return false;
    }

    public static function tableName()
    {
        return '{{%shops}}';
    }

    public function afterFind(): void
    {
        $delivery = Json::decode($this->getAttribute('delivery_json'));
        $this->delivery = Delivery::create(
            $delivery['onCity'] ?? null,
            $delivery['costCity'] ?? null,
            $delivery['minAmountCity'] ?? null,
            $delivery['minAmountCompany'] ?? null,
            $delivery['period'] ?? null,
            $delivery['deliveryCompany'] ?? [],
            $delivery['onPoint'] ?? null,
            new BookingAddress(
                $delivery['addressPoint']['address'] ?? null,
                $delivery['addressPoint']['latitude'] ?? null,
                $delivery['addressPoint']['longitude'] ?? null
            )
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $delivery = $this->delivery;
        $this->setAttribute('delivery_json', Json::encode([
            'onCity' => $delivery->onCity,
            'costCity' => $delivery->costCity,
            'minAmountCity' => $delivery->minAmountCity,
            'minAmountCompany' => $delivery->minAmountCompany,
            'period' => $delivery->period,
            'deliveryCompany' => $delivery->deliveryCompany,
            'onPoint' => $delivery->onPoint,
            'addressPoint' => [
                'address' => $delivery->addressPoint->address,
                'latitude' => $delivery->addressPoint->latitude,
                'longitude' => $delivery->addressPoint->longitude,
            ],
        ]));

        return parent::beforeSave($insert);
    }

    //****** Внешние связи ****************************

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['shop_id' => 'id']);
    }
}