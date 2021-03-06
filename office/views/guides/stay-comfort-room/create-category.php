<?php
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortRoomCategoryForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model StayComfortRoomCategoryForm */


$this->title = 'Создать категорию Удобства';
$this->params['breadcrumbs'][] = ['label' => 'Категории Удобств', 'url' => ['/guides/stay-comfort-room/categories']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<div class="comfort-category-create">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>
            </div>
            <div class="row">
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