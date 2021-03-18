<?php

use booking\entities\admin\Legal;
use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $fun Fun */


$this->title = 'Цены для ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Цены';
?>
<div class="funs-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $fun->baseCost,
                'attributes' => [
                    [
                        'attribute' => 'adult',
                        'label' => 'Билет для взрослых',
                    ],
                    [
                        'attribute' => 'child',
                        'label' => 'Билет для детей',
                    ],
                    [
                        'attribute' => 'preference',
                        'label' => 'Билет для льготных граждан',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Билеты</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $fun,
                'attributes' => [
                    [
                        'attribute' => 'quantity',
                        'label' => 'Кол-во доступных билетов/мест',
                    ],
                    [
                        'attribute' => 'type_time',
                        'label' => 'Тип билета',
                        'value' => $fun->type_time ? Fun::TYPE_TIME_ARRAY[$fun->type_time] : 'не задано',
                    ],
                    [
                        'attribute' => '',
                        'label' => 'Временной интервал',
                        'value' => function (Fun $fun) {
                            if (Fun::isClearTimes($fun->type_time)) return '';
                            $result = '';
                            foreach ($fun->times as $time) {
                                $result .= '<span class="badge badge-info">'. $time->begin .'</span>' . ($time->end != null ? ' - <span class="badge badge-info">'. $time->end .'</span>' : '') . '<br>';
                            }
                            return $result;
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $fun,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($fun) {
                                    $legal = Legal::findOne($fun->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => BookingHelper::cancellation($fun->cancellation),
                            ],
                            [
                                'attribute' => 'prepay',
                                'label' => 'Предоплата (%)',
                                'value' => $fun->prepay,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/fun/finance/update', 'id' => $fun->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>

