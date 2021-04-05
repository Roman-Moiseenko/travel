<?php


use booking\forms\office\guides\ShopTypeForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model ShopTypeForm */


$this->title = 'Редактировать категорию магазина';
$this->params['breadcrumbs'][] = ['label' => 'Категории магазинов', 'url' => ['/guides/shop-type']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="shop-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название категории') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Ссылка') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

