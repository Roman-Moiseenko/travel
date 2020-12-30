<?php

use booking\entities\booking\cars\Car;

/* @var  $car Car */
/* @var $this yii\web\View */
/* @var $ChartWidget string */

$this->title = 'Отчеты по ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Отчеты';

?>
<div class="car-report">
    <div class="row">
        <div class="col-sm-6">
            <?= $ChartWidget ?>
        </div>
        <div class="col-sm-6">
            Виджет Будущие выплаты //СКОРО
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            Виджет Прошлые выплаты //СКОРО
        </div>
        <div class="col-sm-6">
            Виджет Статистика по объекту //СКОРО
        </div>
    </div>
</div>
