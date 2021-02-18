<?php
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\helpers\stays\ComfortHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model StayComfortForm */


$this->title = 'Изменить Удобство';
$this->params['breadcrumbs'][] = ['label' => 'Общие Удобства', 'url' => ['/guides/stay-comfort']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<div class="comfort-category-create">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'category_id')->dropdownList(ComfortHelper::listCategories(), ['prompt' => ''])->label('Категория') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'paid')->checkbox(['maxlength' => true])->label('Возможна платная функция') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'featured')->checkbox(['maxlength' => true])->label('Рекомендуемый') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>