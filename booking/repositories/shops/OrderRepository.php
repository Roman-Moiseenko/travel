<?php


namespace booking\repositories\shops;


use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\entities\shops\Shop;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$product = Order::findOne($id)) {
            throw new \DomainException('Заказ не найден');
        }
        return $product;
    }

    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \DomainException('Заказ не сохранен');
        }
    }

    public function remove(Order $order)
    {
        if (!$order->delete()) {
            throw new \DomainException('Ошибка удаления Заказа');
        }
    }

    public function getByPaymentId($payment_id)
    {
        if (!$order = Order::findOne(['payment_id' => $payment_id])) {
            throw new \DomainException('Заказ не найден');
        }
        return $order;
    }

    public function getNew($user_id): DataProviderInterface
    {
        $orders = Order::find()
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['IN', 'current_status', [StatusHistory::ORDER_PREPARE, StatusHistory::ORDER_NEW, StatusHistory::ORDER_CONFIRMATION, StatusHistory::ORDER_TO_PAY]]);
        return $this->getProvider($orders);
    }

    public function getWork($user_id): DataProviderInterface
    {
        $orders = Order::find()
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['IN', 'current_status', [StatusHistory::ORDER_PAID, StatusHistory::ORDER_FORMED, StatusHistory::ORDER_SENT]]);
        return $this->getProvider($orders);
    }

    public function getCompleted($user_id): DataProviderInterface
    {
        $orders = Order::find()
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['current_status' => StatusHistory::ORDER_COMPLETED]);
        return $this->getProvider($orders);
    }

    public function getCanceled($user_id): DataProviderInterface
    {
        $orders = Order::find()
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['current_status' => StatusHistory::ORDER_CANCELED]);
        return $this->getProvider($orders);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 6,
                'pageSizeLimit' => [6, 6],
            ],
        ]);
    }

    public function getCountsArray($user_id): array
    {
        return [
            'new' => Order::find()->andWhere(['user_id' => $user_id])
                ->andWhere(['IN', 'current_status', [StatusHistory::ORDER_PREPARE, StatusHistory::ORDER_NEW, StatusHistory::ORDER_CONFIRMATION, StatusHistory::ORDER_TO_PAY]])->count(),
            'work' => Order::find()->andWhere(['user_id' => $user_id])
                ->andWhere(['IN', 'current_status', [StatusHistory::ORDER_PAID, StatusHistory::ORDER_FORMED, StatusHistory::ORDER_SENT]])->count(),
            'completed' => Order::find()->andWhere(['user_id' => $user_id])
                ->andWhere(['current_status' => StatusHistory::ORDER_COMPLETED])->count(),
            'canceled' => Order::find()->andWhere(['user_id' => $user_id])
                ->andWhere(['current_status' => StatusHistory::ORDER_CANCELED])->count(),
        ];
    }

    public function getByUser(int $id)
    {
        $orders = Order::find()->alias('o')->andWhere([
            'IN',
            'shop_id',
            Shop::find()->andWhere(['user_id'=>$id])->select('id')
        ])->andWhere([
            'IN',
            'current_status',
            [StatusHistory::ORDER_NEW, StatusHistory::ORDER_PAID]
        ])->all();
        return $orders;
    }
}