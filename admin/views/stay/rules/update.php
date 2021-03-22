<?php

use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\stays\rules\WiFi;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayRulesForm;
use booking\helpers\stays\StayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model StayRulesForm */
/* @var $stay Stay */

$status_not = Rules::STATUS_NOT;
$status_free = Rules::STATUS_FREE;
$status_pay = Rules::STATUS_PAY;

$js_beds = <<<JS
$(document).ready(function() {
    f_c($('#child-on').is(':checked'));
    f_a($('#adult-on').is(':checked'));
    
    $('body').on('click', '#child-on', function() {
        f_c($(this).is(':checked'));
    });
    $('body').on('click', '#adult-on', function() {
        f_a($(this).is(':checked'));
    });
    
    function f_c(_x) {
        if (_x) {
            $('#span-child-on').show();
        } else {
            $('#span-child-on').hide();
        }      
    }
    function f_a(_x) {
        if (_x) {
            $('#span-adult-on').show();
        } else {
            $('#span-adult-on').hide();
        }      
    }
});
JS;
$js_parking = <<<JS
$(document).ready(function() {
    f($('#parking-status').val());
    $('body').on('change', '#parking-status', function() {
        f($(this).val());
    });
    
    function f(_status) {
        if (_status == $status_not || _status == "") {
            $('.span-parking-on').hide();            
            $('.span-parking-pay').hide();
        } 
        if (_status == $status_free){
            $('.span-parking-on').show();            
            $('.span-parking-pay').hide();
        }
        if (_status == $status_pay){
            $('.span-parking-on').show();            
            $('.span-parking-pay').show();
        }      
    }
});
JS;
$js_checkin = <<<JS
$(document).ready(function() {
    $('body').on('change', '.checkin', function() {
        let a1 = $('#checkout-from').val();
        let a2 = $('#checkout-to').val();
        let b1 = $('#checkin-from').val();
        let b2 = $('#checkin-to').val();
        if (a1 < a2 && a2 < b1 && b1 < b2) {
            $('#error-checkin').hide();
        }
        else {
            $('#error-checkin').show(); 
        }

    });

});
JS;
$js_limit = <<<JS
$(document).ready(function() {
    f($('#limit-children').is(':checked'));
    $('body').on('click', '#limit-children', function() {
        f($(this).is(':checked'))
    });

    function f(_x) {
      if (_x){
          $('#span-limit-children-allow').show();
      } else  {
          $('#span-limit-children-allow').hide();
      }
    }
});
JS;
$js_wifi = <<<JS
$(document).ready(function() {
    f($('#wifi-status').val());
    $('body').on('change', '#wifi-status', function() {
        f($(this).val());
    });
    
    function f(_status) {
        if (_status == $status_pay){
            $('.span-wifi-pay').show();
        } else {
            $('.span-wifi-pay').hide();            
        }
    }
});
JS;
$this->registerJs($js_beds);
$this->registerJs($js_parking);
$this->registerJs($js_checkin);
$this->registerJs($js_limit);
$this->registerJs($js_wifi);

$this->title = 'Правила размещения ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="rules">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden'])->label(false) ?>
    <div class="card card-secondary">
        <div class="card-header">Правила размещения на кроватях</div>
        <div class="card-body">
            <?= $form->field($model->beds, 'child_on')->checkbox(['id' => 'child-on'])
                ->label('Допускается установка дополнительных детских кроватей') ?>
            <span id="span-child-on" style="display: none;">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model->beds, 'child_agelimit')->dropdownList(StayHelper::listNumber(1, 12), ['prompt' => '', 'id' => 'child-agelimit'])
                            ->label('По какой возраст ребенка устанавливается доп.кровать') ?>
                    </div>
                <div class="col-sm-6">
                    <?= $form->field($model->beds, 'child_cost')->textInput(['id' => 'child-cost'])
                        ->label('Стоимость детской дополнительной кровати')->hint('Оставьте пустым, если бесплатно') ?>
                </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model->beds, 'child_count')->dropdownList(StayHelper::listNumber(0, 6), ['prompt' => '', 'id' => 'child-count'])
                            ->label('Максимально допустимое кол-во дополнительных детских кроватей') ?>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </span>
            <?= $form->field($model->beds, 'child_by_adult')->dropdownList(StayHelper::listChildAge(), ['prompt' => '', 'id' => 'child-by-adult', 'style' => 'width: 40%;'])
                ->label('С какого возраста ребенок считается взрослым для размещения на кровати') ?>
            <?= $form->field($model->beds, 'adult_on')->checkbox(['id' => 'adult-on'])
                ->label('Допускается установка дополнительных кроватей') ?>
            <span id="span-adult-on" style="display: none;">
                <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model->beds, 'adult_cost')->textInput(['id' => 'adult-cost'])
                        ->label('Стоимость дополнительной кровати')->hint('Оставьте пустым, если бесплатно') ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model->beds, 'adult_count')->dropdownList(StayHelper::listNumber(0, 6), ['prompt' => '', 'id' => 'adult-count'])
                        ->label('Максимально допустимое кол-во дополнительных кроватей') ?>
                </div>
            </div>
            </span>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header">Парковка</div>
        <div class="card-body">
            <div class="row form-inline">
                <div class="col-sm-4">
                    <?= $form->field($model->parking, 'status')->dropdownList(Rules::listStatus(), ['prompt' => '', 'id' => 'parking-status'])
                        ->label('Гостям предоставляется парковка?') ?>
                </div>
                <div class="col-sm-3">
                    <span class="span-parking-on" style="display: none;">
                    <?= $form->field($model->parking, 'private')->dropdownList(Parking::listPrivate(), ['prompt' => '', 'id' => 'parking-private'])
                        ->label(false) ?>
                    </span>
                </div>
                <div class="col-sm-3">
                    <span class="span-parking-on" style="display: none;">
                    <?= $form->field($model->parking, 'inside')->dropdownList(Parking::listInside(), ['prompt' => '', 'id' => 'parking-inside'])
                        ->label(false) ?>
                    </span>
                </div>
            </div>
            <span class="span-parking-on" style="display: none;">
                <div class="row pt-2">
                    <div class="col-sm-4">
                        <?= $form->field($model->parking, 'reserve')->dropdownList([false => 'Нет', true => 'Нужно бронировать', ], ['prompt' => '', 'id' => 'parking-reserve'])
                            ->label('Нужно ли заранее бронировать место?') ?>
                    </div>
                    <div class="col-sm-2">
                        <span class="span-parking-pay" style="display: none;">
                        <?= $form->field($model->parking, 'cost')->textInput(['id' => 'parking-cost'])
                            ->label('Цена за парковку') ?>
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <span class="span-parking-pay" style="display: none;">
                        <?= $form->field($model->parking, 'cost_type')->dropdownList(Parking::listCost(), ['prompt' => '', 'id' => 'parking-cost-type'])
                            ->label('за:') ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model->parking, 'security')->checkbox(['id' => 'parking-security'])
                            ->label('Охраняемая парковка') ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model->parking, 'covered')->checkbox(['id' => 'parking-covered'])
                            ->label('Крытая парковка') ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model->parking, 'street')->checkbox(['id' => 'parking-street'])
                            ->label('Уличная парковка') ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model->parking, 'invalid')->checkbox(['id' => 'parking-invalid'])
                            ->label('Парковочные места для инвалидов') ?>
                    </div>
                </div>
            </span>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header">Правила заселения</div>
        <div class="card-body">
            <div class="row">
                <label>
                    Время заезда гостей
                </label>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model->checkin, 'checkin_from')
                        ->dropdownList(StayHelper::listTime(8, 23), ['prompt' => '--:--', 'class' => 'form-control checkin', 'id' => 'checkin-from'])
                        ->label('c') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model->checkin, 'checkin_to')
                        ->dropdownList(StayHelper::listTime(9, 24), ['prompt' => '--:--', 'class' => 'form-control checkin', 'id' => 'checkin-to'])
                        ->label('по') ?>
                </div>
            </div>
            <div class="row">
                <label>
                    Время отъезда гостей
                </label>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model->checkin, 'checkout_from')
                        ->dropdownList(StayHelper::listTime(0, 21), ['prompt' => '--:--', 'class' => 'form-control checkin', 'id' => 'checkout-from'])
                        ->label('с') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model->checkin, 'checkout_to')
                        ->dropdownList(StayHelper::listTime(1, 22), ['prompt' => '--:--', 'class' => 'form-control checkin', 'id' => 'checkout-to'])
                        ->label('по') ?>
                </div>
            </div>
            <div class="row" id="error-checkin" style="display: none; color: red">
                Ошибка диапозонов времени (возможно пересечение или нет перерыва между отъездом и заселением), проверьте поля.
            </div>
            <div class="row">
                <?= $form->field($model->checkin, 'message')->checkbox()->label('Вы хотели бы знать заранее время заезда гостей?') ?>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header">WiFi</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
            <?= $form->field($model->wifi, 'status')
                ->dropdownList(Rules::listStatus(), ['prompt' => '', 'id' => 'wifi-status'])->label('Наличие') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model->wifi, 'area')->dropdownList(WiFi::listArea(), ['prompt' => '', 'id' => 'wifi-area'])->label('Место доступа') ?>
                </div>
                <div class="col-sm-2">
                        <span class="span-wifi-pay" style="display: none;">
                    <?= $form->field($model->wifi, 'cost')->textInput()->label('Стоимость WiFi') ?>
                        </span>
                </div>
                <div class="col-sm-2">
                        <span class="span-wifi-pay" style="display: none;">
                    <?= $form->field($model->wifi, 'cost_type')->dropdownList(WiFi::listCost(), ['prompt' => '', 'id' => 'wifi-cost-type'])->label('за:') ?>
                        </span>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-secondary">
        <div class="card-header">Ограничения</div>
        <div class="card-body">
            <?= $form->field($model->limit, 'smoking')->checkbox(['id' => 'limit-smoking'])->label('Разрешено курение в номерах?') ?>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model->limit, 'animals')->dropdownList(Rules::listStatus(), ['prompt' => '', 'id' => 'limit-animals'])->label('Разрешено с животными?') ?>
                </div>
            </div>
            <div class="row form-inline">
                <div class="col-sm-3">
                    <?= $form->field($model->limit, 'children')->checkbox(['id' => 'limit-children'])->label('Разрешено с детьми?') ?>
                </div>
                <div class="col-sm-9">
                    <span id="span-limit-children-allow" style="display: none;">
                        <?= $form->field($model->limit, 'children_allow')
                            ->dropdownList(StayHelper::listChildAge(), ['prompt' => '', 'id' => 'limit-children-allow'])
                            ->label('С какого возраста разрешено заселение детей: ') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group p-2">
        <?php
        if ($stay->filling) {
            echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
