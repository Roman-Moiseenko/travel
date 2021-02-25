<?php

use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\Stay;
use booking\helpers\BookingHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $stay Stay */


$this->title = 'Цены для ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Цены';
?>
<div class="stay-finance">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $stay,
                'attributes' => [
                    [
                        'attribute' => 'cost_base',
                        'label' => 'Базовая цена за 1 ночь',
                    ],
                    [
                        'attribute' => 'guest_base',
                        'label' => 'Количество гостей, включенных в стоимость',
                    ],
                    [
                        'attribute' => 'cost_add',
                        'label' => 'Цена за каждого дополнительного гостя в сутки',
                    ],
                    [
                        'label' => 'Стоимость дополнительной детской кровати',
                        'value' => $stay->rules->beds->child_cost,
                    ],
                    [
                        'label' => 'Стоимость дополнительной кровати',
                        'value' => $stay->rules->beds->adult_cost,
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
                        'model' => $stay,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($stay) {
                                    $legal = Legal::findOne($stay->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => BookingHelper::cancellation($stay->cancellation),
                            ],
                            [
                                'attribute' => 'check_booking',
                                'label' => 'Способ оплаты',
                                'value' => BookingHelper::listCheck()[$stay->check_booking],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/stay/finance/update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>

</div>

