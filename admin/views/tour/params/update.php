<?php

use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourParamsForm;
use booking\helpers\tours\TourHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TourParamsForm */
/* @var $tour Tour */
$private = $tour->params->private ?? 0;


$js=<<<JS
$(document).ready(function() {
    if ($private) {
        $('#tourparamsform-groupmin').attr('readonly', 'readonly');
    }

    $('body').on('change', '#tourparamsform-private', function () {
        let value = $(this).val();
        console.log(value);
        if (value == 1) {
            $('#tourparamsform-groupmin').val('1');
            $('#tourparamsform-groupmin').attr('readonly', 'readonly');
            $('#tourparamsform-groupmin').change();
        } else {
           // $('#toursparamsform-groupmin').val('');
            $('#tourparamsform-groupmin').removeAttr('readonly');
        }
    });
    $('body').on('change', '#agelimitform-on', function () {

        if ($(this).is(':checked')) {
            $('#agelimitform-agemin').val('');
            $('#agelimitform-agemax').val('');
            $('.agelimit-edit').show();

        } else {

            $('.agelimit-edit').hide();
        }
    });
});    
JS;

$this->registerJs($js);

$this->title = 'Редактировать Экскурсию ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Экскурсии', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['/tour/params', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-params">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="card card-secondary">
    <div class="card-header with-border">Основные параметры</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'duration')->
                textInput(['maxlength' => true])->
                label('Длительность экскурсии (0 д 0 ч 00 мин)')->hint('Примеры: 4 ч; 2 ч 30 мин; 55 мин; 2 д. Заполните согласно примеров, это необходимо для автоматического перевода на En') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'private')->dropDownList(TourHelper::listPrivate(), ['prompt' => ''])->label('Группа') ?>
            </div>

            <div class="col-md">
                <?= $form->field($model, 'groupMin')->textInput(['maxlength' => true])->label('Минимальное кол-во в группе') ?>
            </div>

            <div class="col-md">
                <?= $form->field($model, 'groupMax')->textInput(['maxlength' => true])->label('Максимальное кол-во в группе') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model->ageLimit, 'on')->checkbox()->label('Ограничение по возрасту') ?>
            </div>
            <div class="col-md-3 agelimit-edit" id="agelimitmin"  <?= $model->ageLimit->on ? '' : 'style="display: none;"' ?>>
                <?= $form->field($model->ageLimit, 'ageMin')->textInput(['maxlength' => true])->label('Минимальный возраст') ?>
            </div>
            <div class="col-md-3 agelimit-edit"  <?= $model->ageLimit->on ? '' : 'style="display: none;"' ?>>
                <?= $form->field($model->ageLimit, 'ageMax')->textInput(['maxlength' => true])->label('Максимальный возраст') ?>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header with-border">Точка сбора</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <?= $form
                            ->field($model->beginAddress, 'address')
                            ->textInput(['maxlength' => true, 'style' => 'width:100%'])
                            ->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form
                            ->field($model->beginAddress, 'latitude')
                            ->textInput(['maxlength' => true])
                            ->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form
                            ->field($model->beginAddress, 'longitude')
                            ->textInput(['maxlength' => true])
                            ->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header with-border">Точка окончания</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <?= $form
                            ->field($model->endAddress, 'address')
                            ->textInput([
                                'maxlength' => true,
                                'style' => 'width:100%',
                                'id' => 'bookingaddressform-address-2'
                            ])
                            ->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form
                            ->field($model->endAddress, 'latitude')
                            ->textInput([
                                    'maxlength' => true,
                               // 'disabled' => 'disabled',
                                'id' => 'bookingaddressform-latitude-2'
                            ])
                            ->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form
                            ->field($model->endAddress, 'longitude')
                            ->textInput([
                                    'maxlength' => true,
                               // 'disabled' => 'disabled',
                                'id' => 'bookingaddressform-longitude-2'
                            ])
                            ->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div id="map-2" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php if ($tour->filling) {
        echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
    } else {
        echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
    }
    ?>
</div>

<?php ActiveForm::end(); ?>
</div>

