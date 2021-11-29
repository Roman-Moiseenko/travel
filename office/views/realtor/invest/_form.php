<?php

use booking\forms\realtor\land\LandForm;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model LandForm */


?>

<?php $form = ActiveForm::begin([]); ?>
    <div class="card card-secondary">
        <div class="card-header">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'name')->textInput()->label('Название Участка') ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'slug')
                                ->textInput(['maxlength' => true])
                                ->label('Ссылка')
                                ->hint('Оставьте пустым, заполнится автоматически') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'cost')->textInput()->label('Стоимость') ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'title')->textInput()->label('Заголовок') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 5])->label('Описание краткое') ?>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                        'language' => 'ru',
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'initialPreview' => [
                                $land ? $land->getThumbFileUrl('photo', 'admin') : null,
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
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= $form->field($model, 'content')->widget(CKEditor::class)->label('Содержимое')/**/ ?>
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

    <div class="card card-default">
        <div class="card-header with-border">Для SEO</div>
        <div class="card-body">
            <?= $form->field($model->meta, 'title')->textInput()->label('Заголовок') ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2])->label('Описание') ?>
            <?= $form->field($model->meta, 'keywords')->textInput()->label('Ключевые слова') ?>
        </div>
    </div>
    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>