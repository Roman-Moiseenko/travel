<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\cars\Car;
use booking\helpers\BookingHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $car Car */


$this->title = $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $car->status,
            'object_id' => $car->id,
            'object_type' => BookingHelper::BOOKING_TYPE_CAR,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($car->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $car->public_at) : '' ?>
    </div>
</div>

<div class="cars-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $car,
                'attributes' => [
                    [
                        'attribute' => 'type_id',
                        'value' => ArrayHelper::getValue($car, 'type.name'),
                        'label' => 'Категория транспортного средства',
                    ],
                    [
                        'value' => function (Car $model) {
                            if (empty($model->cities)) return 'Вся область';
                            return implode(', ', ArrayHelper::map($model->cities, 'id', 'name'));
                        },
                        'label' => 'Расположение',
                    ]
                ],
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $car,
                'attributes' => [
                    [
                        'attribute' => 'year',
                        'label' => 'Год выпуска',
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Описание',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание EN</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $car,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                    [
                        'attribute' => 'description_en',
                        'label' => 'Описание (En)',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/car/common/update', 'id' => $car->id]), ['class' => 'btn btn-success']) ?>
    </div>


</div>

