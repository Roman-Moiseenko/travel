<?php

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $fun Fun */
/* @var $model FunFinanceForm */


$this->title = 'Изменить оплату ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['/fun/finance', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$mode_confirmation = \Yii::$app->params['mode_confirmation'] ?? false;
$disabled = $mode_confirmation ? ['disabled' => true] : [];

$js = <<<JS
$(document).ready(function() {
    let fun_id = $fun->id;
    let array_times = [];
    
    //Загрузка массива times для обработки на стороне клиента
    $.post("/fun/finance/get-times", {fun_id: fun_id}, function(data) {
            array_times = JSON.parse(data);
            render_times($fun->type_time);
        });          

    
    function render_times(_type_time)
    {
        $.post("/fun/finance/render-times", {type_time: _type_time, times: array_times},
            function (data) {
                $('#times').html(data);  
            }
        );        
    }
    
    $('body').on('change', '#select-type-times', function () {
        array_times = [];
        render_times($(this).val());
    });
    
    $('body').on('click', '.remove-time', function() {
           let i = $(this).data('i');
           array_times.splice(i, 1);
           render_times($('#select-type-times').val());
           
    });
        $('body').on('click', '.add-time', function() {
           let _begin = $('#begin').val();
           let _end =  $('#end').val();
           if (_begin !== "") {
               if (_end === undefined) {
                   array_times.push({begin: _begin, end: null});
                   //console.log(array_times);
                   render_times($('#select-type-times').val());
               } else {
                   if (_end !== "") {
                       array_times.push({begin: _begin, end: _end});
                       render_times($('#select-type-times').val());
                   }
               }
           }
    })
});
JS;

$this->registerJs($js);
?>
<div class="funs-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая цена</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'adult')->textInput(['maxlength' => true])->label('Билет для взрослых') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'child')->textInput(['maxlength' => true])->label('Билет для детей') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'preference')->textInput(['maxlength' => true])->label('Билет для льготных граждан') ?>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Билеты</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true])->label('Кол-во доступных билетов/мест (на каждый временной интервал)') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'type_time')->dropDownList(Fun::TYPE_TIME_ARRAY, ['prompt' => '', 'id' => 'select-type-times'])->label('Тип билета (временной интервал)') ?>
            </div>
            <div class="col-md-6">
                <div id="times">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация') ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cancellation')
                                ->textInput(['maxlength' => true])->label('Отмена бронирования *')
                                ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.<br>* при оплате через сайт') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'pay_bank')
                                ->checkbox($disabled)->label('Комиссию банка оплачивает Провайдер')
                                ->hint('Для повышения лояльности Клиентов, старайтесь самостоятельно оплачивать комиссию банка.') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'check_booking')
                                ->radioList(BookingHelper::listCheck(), ['itemOptions' => $disabled])->label('Способ оплаты:')
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

