<?php

/* @var $user User */

/* @var $model PersonalForm */

use booking\entities\admin\user\User;
use booking\forms\admin\PersonalForm;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменить Профиль';
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['/cabinet/profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="card card-secondary" id="photos">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4" style="text-align: center">
                    <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'initialPreview' => [
                                $user->personal->getThumbFileUrl('photo', 'profile'),
                            ],
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => false,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model->fullname, 'surname')->textInput()->label('Фамилия'); ?>
                    <?= $form->field($model->fullname, 'firstname')->textInput()->label('Имя'); ?>
                    <?= $form->field($model->fullname, 'secondname')->textInput()->label('Отчество'); ?>
                    <?= $form->field($model, 'datebornform')->label('Дата рождения')->widget(DatePicker::class, [
                        'type' => DatePicker::TYPE_INPUT,
                        'language' => 'ru',
                        'pluginOptions' => [

                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                        ]
                    ]); ?>

                    <?= $form->field($model, 'phone')->textInput()->label('Телефон'); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Адрес</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->address, 'index')->textInput()->label('Индекс'); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model->address, 'town')->textInput()->label('Город'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model->address, 'address')->textInput()->label('Адрес')->hint('Улица, Дом, Кв'); ?>
                </div>
            </div>
            <div class="row">

                <div class="col-md-9">
                    <?= $form->field($model, 'position')->textInput()->label('Должность'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
