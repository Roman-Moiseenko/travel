<?php

use booking\entities\booking\tours\Tour;

/* @var  $tour Tour */
/* @var $this yii\web\View */
/* @var $ChartWidget string */

$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="tour-report">
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
