<?php

use booking\entities\admin\user\UserLegal;
use booking\entities\booking\tours\Tour;
use booking\helpers\ToursHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tour */


$this->title = 'Тур ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $tours->baseCost,
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $tours,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($tours) {
                                    $legal = UserLegal::findOne($tours->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => ToursHelper::cancellation($tours->cancellation),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/tours/finance/update', 'id' => $tours->id]), ['class' => 'btn btn-success']) ?>
    </div>

</div>

