<?php

use admin\widgest\report\ChartWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\cars\Car;
use booking\forms\admin\ChartForm;

/* @var  $car Car */
/* @var $this yii\web\View */
/* @var $form ChartForm */

$this->title = 'Отчеты по ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Отчеты';

?>
<div class="car-report">
    <?= StaticWidget::widget([
        'object' => $car,
    ]) ?>
    <?= ChartWidget::widget([
        'object' => $car,
        'form' => $form,
    ]); ?>
</div>
