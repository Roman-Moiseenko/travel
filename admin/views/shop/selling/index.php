<?php


use admin\forms\shops\OrderSearch;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\entities\shops\Shop;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shop Shop */


$this->title = 'Заказы';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <div class="card">
        <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'label' => '#ID',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'ID'],
            ],
            [
                'attribute' => 'number',
                'label' => 'Номер заказа',
                'value' => function (Order $model) {
                    return Html::a($model->number, Url::to(['view', 'id' => $model->id]));
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Номер заказа'],
            ],
            [
                'attribute' => 'created_at',
                'value' => function (Order $model) {
                    return date('d-m-Y H:i', $model->created_at);
                },
                'format' => 'raw',
                'label' => 'Дата',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Дата'],
            ],
            [
                'attribute' => 'current_status',
                'label' => 'Статус',
                'value' => function (Order $model) {
                    return StatusHistory::toHtml($model->current_status);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => StatusHistory::ARRAY_ADMIN,
                'contentOptions' => ['data-label' => 'Статус'],
            ],

            [
                'attribute' => 'payment_full_cost',
                'label' => 'Сумма заказа',
                'value' => function (Order $model) {
                    return CurrencyHelper::stat($model->payment->full_cost);
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Сумма заказа'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>
