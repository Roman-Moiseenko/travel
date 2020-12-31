<?php

use booking\entities\booking\tours\Tour;

/* @var  $tour Tour */
/* @var $this yii\web\View */
/* @var $ChartWidget string */
/* @var $PaymentNextWidget string */
/* @var $PaymentPastWidget string */
/* @var $StaticWidget string */

$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="tour-report">
    <div class="row">
        <div class="col-sm-8">
            <?= $ChartWidget ?>
        </div>
        <div class="col-sm-4">
            <?= $StaticWidget ?>
        </div>
    </div>
</div>
