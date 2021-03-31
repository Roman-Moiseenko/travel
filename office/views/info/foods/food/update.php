<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\foods\Food;
use booking\entities\message\ThemeDialog;
use booking\forms\foods\KitchenForm;
use booking\forms\office\guides\ThemeDialogForm;
use booking\helpers\DialogHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model KitchenForm */
/* @var $food Food */


$this->title = 'Редактировать заведение';
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['/info/foods/food/index']];
$this->params['breadcrumbs'][] = ['label' => $food->name, 'url' => ['/info/foods/food/view', 'id' => $food->id]];

$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="food-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

