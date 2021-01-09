<?php

use booking\entities\finance\Refund;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use office\forms\finance\RefundSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выплаты клиентам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-list">
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
                        'options' => ['width' => '20px',],
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'value' => function (Refund $model) {
                            return $model->user->personal->fullname->getShortname();
                        },
                        'format' => 'raw',
                        'label' => 'Клиент',
                        'contentOptions' => ['data-label' => 'Клиент'],
                    ],
                    [
                        'attribute' => 'booking_id',
                        'value' => function (Refund $model) {
                            return $model->booking->getName();
                        },
                        'label' => 'Объект бронирования',
                        'contentOptions' => ['data-label' => 'Объект бронирования'],
                    ],
                    [
                            'value' => function (Refund $model) {
                                return BookingHelper::number($model->booking);
                            },
                        'label' => 'Номер бронирования',
                        'contentOptions' => ['data-label' => 'Номер бронирования'],

                    ],
                    [
                        'attribute' => 'amount',
                        'value' => function (Refund $model) {
                            return CurrencyHelper::cost($model->amount);
                        },
                        'label' => 'Сумма возврата',
                        'contentOptions' => ['data-label' => 'Сумма возврата'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                $url = Url::to(['/finance/client/refund', 'id' => $model->id]);
                                $icon = Html::tag('i', '', ['class' => "fas fa-cash-register"]);
                                return Html::a($icon, $url, [
                                    'title' => 'Отметить как выплаченные',
                                    'aria-label' => 'Отметить как выплаченные',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Подтвердите возврат денежных средств ' . $model->user->personal->fullname->getShortname() . '?',
                                    'data-method' => 'post',
                                ]);

                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
