<?php

use booking\entities\booking\funs\Fun;

/* @var  $fun Fun */
/* @var $this yii\web\View */
/* @var $ChartWidget string */
/* @var $PaymentNextWidget string */
/* @var $PaymentPastWidget string */
/* @var $StaticWidget string */

$this->title = 'Отчеты по ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="fun-report">
    <div class="row">
        <div class="col-sm-8">
            <?= $ChartWidget ?>
        </div>
        <div class="col-sm-8">
            <?= $StaticWidget ?>
        </div>
    </div>
</div>
