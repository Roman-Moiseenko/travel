<?php

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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

$_type_times = Fun::TYPE_TIME_INTERVAL;

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
        if ($(this).val() == $_type_times) {
            $('#check-multi').attr("checked","checked");
            $('#check-multi').change();
        } else {
            $('#check-multi').removeAttr("checked");
            $('#check-multi').change();
        }
    });
    
    $('body').on('click', '#check-multi', function () {
        if ($(this).is(':checked')) {
            $('#select-type-times').val($_type_times);
            $('#select-type-times').change();
            render_times($('#select-type-times').val());
        }
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
            <?php if ($fun->type->isMulti()): ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'multi')->checkbox(['id' => 'check-multi'])->label('Множественный выбор')->hint('Несколько подряд временных интервалов в одном билете') ?>
                </div>
            <?php endif; ?>
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
                            <?php if (count(AdminUserHelper::listLegals()) == 0) {
                                echo Html::a('Добавить организацию', Url::to(['/legal/create']), ['class' => 'btn btn-warning']);
                            } else {
                                echo $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация');
                            } ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cancellation')
                                ->textInput(['maxlength' => true])->label('Отмена бронирования *')
                                ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.<br>* при оплате через сайт') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <?= $form->field($model, 'prepay')
                                ->dropdownList(BookingHelper::listPrepay())->label('Предоплата (%):')
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php if (count(AdminUserHelper::listLegals()) == 0) {
            echo Html::submitButton('Добавьте организацию!', ['class' => 'btn btn-success', 'disabled' => 'disabled']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        } ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

