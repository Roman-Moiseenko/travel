<?php

use booking\forms\office\guides\DutyForm;

/* @var $this yii\web\View */
/* @var  $model DutyForm */


$this->title = 'Редактировать Сбор';
$this->params['breadcrumbs'][] = ['label' => 'Сборы', 'url' => ['/guides/duty']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

