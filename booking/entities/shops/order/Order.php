<?php


namespace booking\entities\shops\order;


use booking\entities\admin\Legal;
use booking\entities\booking\Payment;
use booking\entities\PaymentInterface;
use booking\entities\shops\Shop;
use booking\entities\user\User;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Order
 * @package booking\entities\shops\order
 * @property integer $id
 * @property integer $shop_id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $number
 * @property string $comment
 * @property string $document -- скрин, фото что заказ выдан (чек)/отправлен ТК (накладная)
 * @property int $current_status
 *
 ************** Оплата
 * @property boolean $unload
 * @property string $payment_id [varchar(255)]
 * @property float $payment_provider [float]
 * @property float $payment_merchant [float]
 * @property float $payment_deduction [float]
 * @property int $payment_date [int]
 * @property int $payment_full_cost [int]
 * @property int $payment_prepay [int]
 * @property int $payment_percent [int] всегда 100%
 * @property string $payment_confirmation [varchar(255)]
 *
 ************* Доставка
 * @property integer $delivery_method
 * @property string $delivery_address_index
 * @property string $delivery_address_city
 * @property string $delivery_address_street
 * @property boolean $delivery_on_hands
 * @property string $delivery_fullname
 * @property string $delivery_phone
 * @property integer $delivery_company
 *
 *************  Внешние связи
 * @property StatusHistory[] $statuses
 * @property StatusHistory $lastStatus
 * @property OrderItem[] $items
 * @property User $user
 * @property Shop $shop
 *
 * @mixin ImageUploadBehavior
 */
class Order extends ActiveRecord implements PaymentInterface
{
    /** @var $deliveryData DeliveryData */
    public $deliveryData;
    /** @var $payment Payment */
    public $payment;

    public static function create($user_id, $shop_id, array $items, $comment, DeliveryData $deliveryData): self
    {
        $order = new static();
        $order->user_id = $user_id;
        $order->shop_id = $shop_id;
        //$order->legal_id = $legal_id;
        $order->comment = $comment;
        $order->items = $items;
        $order->deliveryData = $deliveryData;

        $order->unload = false;
        $order->payment = new Payment();
        $order->created_at = time();

        $order->updatePayment();
        $order->generateNumber();

        $order->setStatus(StatusHistory::ORDER_PREPARE);
        return $order;
    }

    public function setStatus($status, $comment = null): void
    {
        $this->current_status = $status;
        $statuses = $this->statuses;
        $statuses[] = StatusHistory::created($status, $comment);
        $this->statuses = $statuses;
    }

    public function setDelivery(DeliveryData $deliveryData): void
    {
        $this->deliveryData = $deliveryData;
    }

    public function delItem($id): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($id)) {
                unset($items[$i]);
                $this->items = $items;
                $this->updatePayment();
                return;
            }
        }
        throw new \DomainException('Не найден элемент ' . $id);
    }

    private function generateNumber(): void
    {
        $year = date('Y');
        $count = (int)(Order::find()->andWhere(['shop_id' => $this->shop_id])->count()) + 1;
        $this->number = $year . '-' . $this->shop_id . '/' . $count;
    }

    private function updatePayment()
    {
        $deduction = \Yii::$app->params['deduction'];
        $merchant = \Yii::$app->params['merchant'];

        $this->payment->full_cost = $this->fullCost();
        $this->payment->percent = 100;
        $this->payment->prepay = $this->payment->full_cost;

        $this->payment->merchant = $this->payment->prepay * $merchant / 100; //
        $this->payment->deduction = $this->payment->full_cost * $deduction / 100;
        $this->payment->provider = $this->payment->prepay - $this->payment->merchant - $this->payment->deduction;
    }

    private function fullCost(): float
    {
        $cost = 0;
        foreach ($this->items as $item) {
            $cost += $item->getCost();
        }
        return $cost;
    }

    //********* is *******************
    public function isPrepare()
    {
        return $this->current_status == StatusHistory::ORDER_PREPARE;
    }

    public function isNew()
    {
        return $this->current_status == StatusHistory::ORDER_NEW;
    }

    public function isConfirmation()
    {
        return $this->current_status == StatusHistory::ORDER_CONFIRMATION;
    }

    public function isToPay()
    {
        return $this->current_status == StatusHistory::ORDER_TO_PAY;
    }

    public function isPaid()
    {
        return $this->current_status == StatusHistory::ORDER_PAID;
    }

    public function isFormed()
    {
        return $this->current_status == StatusHistory::ORDER_FORMED;
    }

    public function isSent()
    {
        return $this->current_status == StatusHistory::ORDER_SENT;
    }

    public function isCompleted()
    {
        return $this->current_status == StatusHistory::ORDER_COMPLETED;
    }

    public function isCanceled()
    {
        return $this->current_status == StatusHistory::ORDER_CANCELED;
    }

    public static function tableName()
    {
        return '{{%shops_order}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'items',
                    'statuses',
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'document',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/orders/[[attribute_shop_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/orders/[[attribute_shop_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/orders/[[attribute_shop_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/orders/[[attribute_shop_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'list' => ['width' => 150, 'height' => 150],
                    'catalog_origin' => ['width' => 1080, 'height' => 720],
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

    public function afterFind(): void
    {
        $this->deliveryData = DeliveryData::create(
            $this->getAttribute('delivery_method'),
            $this->getAttribute('delivery_address_index'),
            $this->getAttribute('delivery_address_city'),
            $this->getAttribute('delivery_address_street'),
            $this->getAttribute('delivery_on_hands'),
            $this->getAttribute('delivery_fullname'),
            $this->getAttribute('delivery_phone'),
            $this->getAttribute('delivery_company')
        );
        $this->payment = new Payment(
            $this->getAttribute('payment_full_cost'),
            $this->getAttribute('payment_id'),
            $this->getAttribute('payment_date'),
            $this->getAttribute('payment_prepay'),
            $this->getAttribute('payment_percent'),
            $this->getAttribute('payment_provider'),
            $this->getAttribute('payment_merchant'),
            $this->getAttribute('payment_deduction'),
            $this->getAttribute('payment_confirmation'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('delivery_method', $this->deliveryData->method);
        $this->setAttribute('delivery_address_index', $this->deliveryData->address_index);
        $this->setAttribute('delivery_address_city', $this->deliveryData->address_city);
        $this->setAttribute('delivery_address_street', $this->deliveryData->address_street);
        $this->setAttribute('delivery_on_hands', $this->deliveryData->on_hands);
        $this->setAttribute('delivery_fullname', $this->deliveryData->fullname);
        $this->setAttribute('delivery_phone', $this->deliveryData->phone);
        $this->setAttribute('delivery_company', $this->deliveryData->company);

        $this->setAttribute('payment_full_cost', $this->payment->full_cost);
        $this->setAttribute('payment_id', $this->payment->id);
        $this->setAttribute('payment_date', $this->payment->date);
        $this->setAttribute('payment_prepay', $this->payment->prepay);
        $this->setAttribute('payment_percent', $this->payment->percent);
        $this->setAttribute('payment_provider', $this->payment->provider);
        $this->setAttribute('payment_merchant', $this->payment->merchant);
        $this->setAttribute('payment_deduction', $this->payment->deduction);
        $this->setAttribute('payment_confirmation', $this->payment->confirmation);

        return parent::beforeSave($insert);
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public function getStatuses(): ActiveQuery
    {
        return $this->hasMany(StatusHistory::class, ['order_id' => 'id']);
    }
    public function getLastStatus(): ActiveQuery
    {
        return $this->hasOne(StatusHistory::class, ['order_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

    public function getItem($id): OrderItem
    {
        $items = $this->items;
        foreach ($items as $item) {
            if ($item->isFor($id)) {
                return $item;
            }
        }
        throw new \DomainException('Не найден элемент заказа ' . $id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLegal(): Legal
    {
        return $this->shop->legal;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function loadDocument(UploadedFile $file)
    {
        $this->document = $file;
    }
}