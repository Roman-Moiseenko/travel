<?php

use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\Stay;
use booking\helpers\scr;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.add-services', function() {
        let stay_id = $('#stay-id').val();
        let services = getServices();
        $.post('/stay/services/add', {stay_id: stay_id, services: services, status: "add"}, function(data) {
            
            $('#list-services').html(data);
            
        });
    });
    
    $('body').on('click', '.sub-services', function() {
        let stay_id = $('#stay-id').val();
        let services = getServices();
        let del_services = $(this).data('i');
        services.splice(del_services, 1);
        $.post('/stay/services/add', {stay_id: stay_id, services: services, status: "sub"}, function(data) {
            $('#list-services').html(data);
        });
    });    

    function getServices() {
        let count_services = $('#count-services').val();
        let services = new Array();
        for (let i = 0; i < count_services; i++) {
            services[i] = [
                $('#services-name-' + i).val(), 
                $('#services-value-' + i).val(), 
                $('#services-payment-' + i).val()                
                ];
        }  
        return services;
    }
});
JS;
$this->registerJs($js);

$this->title = 'Услуги ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="services-stay">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden', 'id' => 'stay-id'])->label(false) ?>
    <div class="card card-secondary">
        <div class="card-header">Услуги</div>
        <div class="card-body">
            <div id="list-services">

            <?= $this->render('_services_list', [
                    'services' => $stay->services,
                ]); ?>
            </div>
            <span class="btn add-services" style="color: #0c525d"><i class="far fa-plus-square"></i> Добавить</span>
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
