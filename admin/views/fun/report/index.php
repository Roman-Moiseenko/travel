<?php

use admin\widgest\report\ChartWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\funs\Fun;
use booking\forms\admin\ChartForm;

/* @var  $fun Fun */
/* @var $this yii\web\View */
/* @var $form ChartForm */

$this->title = 'Отчеты по ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="fun-report">
    <?= StaticWidget::widget([
        'object' => $fun,
    ]) ?>
    <?= ChartWidget::widget([
        'object' => $fun,
        'form' => $form,
    ]); ?>
</div>
