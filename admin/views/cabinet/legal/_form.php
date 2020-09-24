<?php

use booking\entities\admin\Legal;
use booking\forms\admin\UserLegalForm;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model UserLegalForm */
/* @var $legal Legal */
?>


<?php $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Организация</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование') ?>
                    <?= $form->field($model, 'INN')->textInput(['maxlength' => true])->label('ИНН') ?>
                    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true])->label('КПП') ?>
                    <?= $form->field($model, 'OGRN')->textInput(['maxlength' => true])->label('ОГРН') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Реквизиты для оплаты</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'BIK')->textInput(['maxlength' => true])->label('БИК банка') ?>
                    <?= $form->field($model, 'account')->textInput(['maxlength' => true])->label('Р/счет') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'caption')->textInput()->label('Заголовок (торговая марка)') ?>
                    <?= $form->field($model, 'description')
                        ->textarea(['rows' => 6])
                        ->label('Описание')->widget(CKEditor::class)
                        ->hint('Баг: При изменении адреса, внесите изменение в описание, иначе не сохраняет новый адрес.') ?>
                </div>
                <div class="col-md-4" style="text-align: center">
                    <?= $form->field($model->photo, 'files')->label('Логотип')->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'initialPreview' =>
                                [
                                    $legal->getThumbFileUrl('photo', 'profile'),
                                ],
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => true,
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Контакты</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'noticePhone')->
                    textInput(['maxlength' => true, 'style' => 'width:100%'])->label('Телефон для уведомлений')->hint('Только цифры, без кода страны: 9110001234') ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'noticeEmail')->
                    textInput(['maxlength' => true, 'style' => 'width:100%'])->label('Почта для уведомлений') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model->address, 'address')->
                    textInput(['maxlength' => true, 'style' => 'width:100%'])->label('Адрес') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'office')->textInput()->label('Офис')//textInput(['maxlength' => true])->label(false)   ?>
                    <?= $form->field($model->address, 'latitude')->hiddenInput()->label(false)//textInput(['maxlength' => true])->label(false)   ?>
                    <?= $form->field($model->address, 'longitude')->hiddenInput()->label(false)// ->textInput(['maxlength' => true])->label(false)   ?>
                </div>
            </div>
            <div class="row">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>