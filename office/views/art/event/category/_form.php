<?php

use booking\entities\art\event\Category;
use booking\forms\art\event\CategoryForm;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model CategoryForm */
/* @var $category Category|null */

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>


<div class="card card-default">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название категории') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Ссылка') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'icon')->textInput(['maxlength' => true])->label('Иконка') ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-default">
    <div class="card-header with-border">Для SEO</div>
    <div class="card-body">
        <?= $form->field($model->meta, 'title')->textInput()->label('Заголовок') ?>
        <?= $form->field($model->meta, 'description')->textarea(['rows' => 2])->label('Описание') ?>
        <?= $form->field($model->meta, 'keywords')->textInput()->label('Ключевые слова') ?>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
