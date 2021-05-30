<?php

use booking\entities\office\PriceList;
use booking\helpers\CurrencyHelper;
use yii\grid\GridView;


/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\finance\PriceListSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Прайс-лист автоплатежей';
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
                        'attribute' => 'name',
                        'label' => 'Название',
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'amount',
                        'value' => function (PriceList $model) {
                            return CurrencyHelper::stat($model->amount, 2);
                        },
                        'format' => 'raw',
                        'label' => 'Платеж',
                        'contentOptions' => ['data-label' => 'Платеж'],
                    ],
                    [
                        'attribute' => 'period',
                        'value' => function (PriceList $model) {
                            return PriceList::ARRAY_PERIOD[$model->period];
                        },
                        'format' => 'raw',
                        'filter' => PriceList::ARRAY_PERIOD,
                        'label' => 'Период',
                        'contentOptions' => ['data-label' => 'Период'],
                    ],
                    [
                        'attribute' => 'key',
                        'label' => 'Ключ',
                        'contentOptions' => ['data-label' => 'Ключ'],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
