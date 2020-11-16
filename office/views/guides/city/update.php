<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\forms\office\guides\ThemeDialogForm;
use booking\helpers\DialogHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model ThemeDialogForm */


$this->title = 'Редактировать город';
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['/guides/city']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

