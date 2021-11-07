<?php

use booking\entities\touristic\fun\Category;
use booking\forms\touristic\fun\CategoryForm;
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
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок H1') ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'description')->textarea(['rows' => 7])->label('Описание') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'initialPreview' => [
                            $category ? $category->getThumbFileUrl('photo', 'admin') : null,
                        ],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                    ],
                ]) ?>
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
