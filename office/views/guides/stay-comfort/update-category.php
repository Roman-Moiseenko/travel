<?php

use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\forms\office\guides\StayComfortCategoryForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model StayComfortCategoryForm */
/* @var $category ComfortCategory */

$this->title = 'Редактировать категорию Удобства ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории Удобств', 'url' => ['/guides/stay-comfort/categories']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<div class="comfort-category-update">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название категории') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'image')->textInput(['maxlength' => true])->label('Картинка') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>