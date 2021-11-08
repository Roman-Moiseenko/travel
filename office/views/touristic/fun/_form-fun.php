<?php

use booking\forms\touristic\fun\FunForm;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model FunForm */


?>


<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<?= $form->field($model, 'category_id')->textInput(['type' => 'hidden'])->label(false) ?>

<div class="card card-secondary">
    <div class="card-header with-border">Общие</div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'name')->textInput()->label('Название Объекта') ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'slug')
                    ->textInput(['maxlength' => true])
                    ->label('Ссылка')
                    ->hint('Оставьте пустым, заполнится автоматически') ?>
            </div>
        </div>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Предварительно Описание</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'title')->textInput()->label('Заголовок H1')->hint('Оставьте пустым, заполнится автоматически') ?>
            </div>
            <div class="col-6">

            </div>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 5])->label('Краткое описание') ?>
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header with-border">Подробное</div>
    <div class="card-body">
        <?= $form->field($model, 'content')->widget(CKEditor::class)->label('Содержимое')/**/ ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Контакты</div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
        <?= $form->field($model->contact, 'phone')->textInput()->label('Телефон') ?>
            </div>
            <div class="col-3">
        <?= $form->field($model->contact, 'url')->textInput()->label('Ссылка на сайт/профиль/соц.сеть') ?>
            </div>
            <div class="col-3">
        <?= $form->field($model->contact, 'email')->textInput()->label('Электронная почта') ?>
            </div>
        </div>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">Карта</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <?= $form->field($model->address, 'address')->
                textInput(['maxlength' => true, 'style' => 'width:100%'])->label(false) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model->address, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model->address, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div id="map" style="width: 100%; height: 600px"></div>
        </div>
    </div>
</div>

<div class="card card-secondary">
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
