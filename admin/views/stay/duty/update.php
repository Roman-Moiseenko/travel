<?php

use booking\entities\booking\stays\duty\Duty;
use booking\entities\booking\stays\Stay;

use booking\entities\booking\stays\StayParams;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayDutyForm;
use booking\forms\booking\stays\StayParamsForm;
use booking\helpers\stays\StayHelper;
use booking\helpers\stays\StayTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model StayDutyForm */
/* @var $stay Stay */

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.check-duty', function() {
       let duty_id = $(this).val();
       if ($(this).is(':checked')) {
           $('#fields-duty-' + duty_id).show();
       } else  {
           $('#fields-duty-' + duty_id).hide();
       }
    });

});
JS;
$this->registerJs($js);

$this->title = 'Дополнительные сборы ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="duty-stay">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden', 'id' => 'stay-id'])->label(false) ?>
    <div class="card card-secondary">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'info',
                'head' => '<span class="badge badge-info">Информация</span>',
                'body' => 'Дополнительные сборы будут добавлены к стоимости проживания, если установлен параметр "Не включен в тариф", в ином случае они носят инфорационных характер.<br>' .
                    'Если Вы хотите добавить возможность выбора Гостю приобретать или нет, то создайте услугу (платную) в следующем блоке.'
            ]) ?>
            </div>
            </div>
            <p></p>
            <?php foreach ($model->assignDuty as $i => $assignDutyForm): ?>
                <div class="row">
                    <div class="col-sm-10">
                        <?= $form
                            ->field($assignDutyForm, '[' . $i . ']duty_id')
                            ->checkbox(['class' => 'check-duty custom-control-input', 'value' => $assignDutyForm->getId(), ((int)$assignDutyForm->duty_id > 0 ? 'checked' : '')])
                            ->label($assignDutyForm->getName()) ?>
                        <div class="row pl-3">
                            <span id="fields-duty-<?= $assignDutyForm->getId() ?>" <?= (int)$assignDutyForm->duty_id > 0 ? '' : "style='display: none;'"?>>
                                <div class="d-flex">
                                    <?= $form->field($assignDutyForm, '[' . $i . ']payment')->dropdownList(Duty::listPayment(), ['prompt' => '--'])->label('Способ оплаты') ?>
                                    <?= $form->field($assignDutyForm, '[' . $i . ']value')->textInput()->label('Размер оплаты') ?>
                                    <?= $form->field($assignDutyForm, '[' . $i . ']include')->dropdownList([false => 'Нет', true => 'Включено'], ['prompt' => '--'])->label('Включено в тариф') ?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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

