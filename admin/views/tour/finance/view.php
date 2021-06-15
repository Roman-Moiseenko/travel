<?php

use booking\entities\admin\Legal;
use booking\entities\booking\tours\services\Capacity;
use booking\entities\booking\tours\services\CapacityAssignment;
use booking\entities\booking\tours\services\Transfer;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\tours\TourHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tour Tour */


$this->title = 'Цены для ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Экскурсии', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Цены';
?>
<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?php
            if ($tour->params->private) {
                echo DetailView::widget([
                    'model' => $tour->baseCost,
                    'attributes' => [
                        [
                            'attribute' => 'adult',
                            'label' => 'Цена за экскурсию',
                        ],
                        [
                            'attribute' => 'extra_time_cost',
                            'label' => 'Цена за дополнительный час экскурсии',
                            'value' => $tour->extra_time_cost ?? '-',
                        ],
                        [
                            'attribute' => 'extra_time_max',
                            'label' => 'Максимальное кол-во дополнительных часов экскурсии',
                            'value' => $tour->extra_time_max ?? '-',
                        ],
                        [
                            'label' => 'Наценка (в %%) за увеличенное количество ',
                            'value' => implode(', ', array_map(function (Capacity $capacity) {
                                return $capacity->count . ' чел. - ' . $capacity->percent . '%';
                            }, $tour->capacities)),
                        ],
                        [
                            'label' => 'Трансфер ',
                            'value' => implode(', ', array_map(function (Transfer $transfer) {
                                return $transfer->from->name . ' - ' . $transfer->to->name . ' ' . CurrencyHelper::cost($transfer->cost);
                            }, $tour->transfers)),
                        ],
                    ],
                ]);
            } else {
                echo DetailView::widget([
                    'model' => $tour->baseCost,
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
                ]);
            }?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $tour,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($tour) {
                                    $legal = Legal::findOne($tour->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => BookingHelper::cancellation($tour->cancellation),
                            ],
                            [
                                'attribute' => 'prepay',
                                'label' => 'Предоплата (%)',
                                'value' => $tour->prepay,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/tour/finance/update', 'id' => $tour->id]), ['class' => 'btn btn-success']) ?>
    </div>

</div>

