<?php

use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\forms\office\guides\NearbyCategoryForm;
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\helpers\stays\ComfortHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model NearbyCategoryForm */


$this->title = 'Изменить Категорию окрестности';
$this->params['breadcrumbs'][] = ['label' => 'Категории окрестностей', 'url' => ['/guides/nearby-category']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<div class="comfort-category-create">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'group')->dropdownList(NearbyCategory::listGroup(), ['prompt' => ''])->label('Группировка') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>