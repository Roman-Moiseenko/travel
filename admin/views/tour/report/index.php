<?php

use admin\widgest\report\ChartWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\tours\Tour;
use booking\forms\admin\ChartForm;

/* @var  $tour Tour */
/* @var $this yii\web\View */
/* @var $form ChartForm */


$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="tour-report">
    <?= StaticWidget::widget([
        'object' => $tour,
    ]) ?>
    <?= ChartWidget::widget([
        'object' => $tour,
        'form' => $form,
    ]); ?>
</div>
