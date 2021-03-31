<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\forms\foods\KitchenForm;
use booking\forms\office\guides\ThemeDialogForm;
use booking\helpers\DialogHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model KitchenForm */


$this->title = 'Добавить Заведение';
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['/info/foods/food/index']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="food-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

