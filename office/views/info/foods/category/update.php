<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\forms\foods\CategoryForm;
use booking\forms\foods\KitchenForm;
use booking\forms\office\guides\ThemeDialogForm;
use booking\helpers\DialogHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model CategoryForm */


$this->title = 'Редактировать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категория заведения', 'url' => ['/info/foods/category']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

