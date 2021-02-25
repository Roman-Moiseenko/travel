<?php


use booking\forms\office\guides\DutyForm;


/* @var $this yii\web\View */
/* @var  $model DutyForm */


$this->title = 'Добавить сбор';
$this->params['breadcrumbs'][] = ['label' => 'Сборы', 'url' => ['/guides/duty']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="city-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

