<?php

use admin\widgest\report\ChartWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\Stay;
use booking\forms\admin\ChartForm;

/* @var  $stay Stay */
/* @var $this yii\web\View */
/* @var $form ChartForm */

$this->title = 'Отчеты по ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Отчеты';

?>
<div class="car-report">
    <?= StaticWidget::widget([
        'object' => $stay,
    ]) ?>
    <?= ChartWidget::widget([
        'object' => $stay,
        'form' => $form,
    ]); ?>
</div>
