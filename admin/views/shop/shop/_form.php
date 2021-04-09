<?php

use booking\forms\shops\ShopCreateForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\shops\DeliveryHelper;
use booking\helpers\shops\ShopTypeHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */

$js = <<<JS
$(document).ready(function() {
    showOnCity($('#on-city').is(':checked'));
    showOnPoint($('#on-point').is(':checked'));
    
    $('body').on('click', '#on-city', function() {
        showOnCity($(this).is(':checked'));
        if (!$(this).is(':checked')) {
            $('#cost-city').val(null);
            $('#min-amount-city').val(null);
        }
    });
    $('body').on('click', '#on-point', function() {
        showOnPoint($(this).is(':checked'));
        if (!$(this).is(':checked')) {
            $('#bookingaddressform-address').val(null);
            $('#bookingaddressform-latitude').val(null);
            $('#bookingaddressform-longitude').val(null);
        }        
    });
    
    function showOnCity(_x) {
        if (_x) {
            $('.span-on-city').show();
        } else {
            $('.span-on-city').hide();
        }      
    }
    function showOnPoint(_x) {
        if (_x) {
            $('.span-on-point').show();
        } else {
            $('.span-on-point').hide();
        }      
    }
});
JS;
$this->registerJs($js);


?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название магазина') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название магазина (En)') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)') ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Дополнительно</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'type_id')->dropDownList(ShopTypeHelper::list(), ['prompt' => ''])->label('Тип') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Доставка</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'onCity')->checkbox(['id' => 'on-city'])->label('Доставка по городу') ?>
                </div>
                <div class="col-md-3 span-on-city">
                    <?= $form->field($model->delivery, 'costCity')->textInput(['type' => 'number', 'min' => 0, 'id' => 'cost-city'])->label('Стоимость доставки по городу') ?>
                </div>
                <div class="col-md-3 span-on-city">
                    <?= $form->field($model->delivery, 'minAmountCity')->textInput(['type' => 'number', 'id' => 'min-amount-city'])->label('Мин.сумма заказа для доставки по городу') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'onPoint')->checkbox(['id' => 'on-point'])->label('Имеется точка выдачи в городе') ?>
                </div>
                <div class="col-md-4 span-on-point">
                    <?= $form->field($model->delivery->addressPoint, 'address')->textInput([])->label('Адрес выдачи') ?>
                </div>
                <div class="col-md-2 span-on-point">
                    <?= $form->field($model->delivery->addressPoint, 'latitude')->textInput(['readonly' => 'readonly'])->label('широта') ?>
                </div>
                <div class="col-md-2 span-on-point">
                    <?= $form->field($model->delivery->addressPoint, 'longitude')->textInput(['readonly' => 'readonly'])->label('долгота') ?>
                </div>
            </div>
            <div class="row span-on-point">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model->delivery, 'minAmountCompany')->textInput(['type' => 'number', 'min' => 0])->label('Мин.сумма заказа для отправки ТК') ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model->delivery, 'period')->dropdownList([0,1,2,3,7])->label('Сколько раз в неделю осуществляется доставка')->hint('0 - в день заказа, 7 - ежедневно') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'deliveryCompany')->checkboxList(DeliveryHelper::list())->label('Транспортные компании') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>