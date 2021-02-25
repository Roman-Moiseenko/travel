<?php

use booking\entities\booking\stays\Stay;

use booking\entities\booking\stays\StayParams;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayParamsForm;
use booking\helpers\stays\StayHelper;
use booking\helpers\stays\StayTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model StayParamsForm */
/* @var $stay Stay */

$js = <<<JS
$(document).ready(function() {
    //f($('#is-deposit').is(':checked'));
    if (Number($('#amount-deposit').val()) > 0) {
        f(true);
        $('#is-deposit').prop('checked', true);
    }
    
    $('body').on('click', '#is-deposit', function() {
        f($(this).is(':checked'))
    });

    function f(_x) {
      if (_x){
          $('#deposit-view').show();
      } else  {
          $('#deposit-view').hide();
      }
    }
});
JS;
$this->registerJs($js);

$this->title = 'Параметры ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="params-stay">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>

    <div class="card card-secondary">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <div class="d-flex">
                        <div>
                            <label>Количество ванных комнат</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form->field($model, 'count_bath')->dropdownList(StayHelper::listNumber(0, 4), ['prompt' => ' -- '])->label(false) ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <label>Количество кухонь</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form->field($model, 'count_kitchen')->dropdownList(StayHelper::listNumber(0, 4), ['prompt' => ' -- '])->label(false) ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <label>Количество этажей в доме</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form->field($model, 'count_floor')->dropdownList(StayHelper::listNumber(1, 25), ['prompt' => ' -- '])->label(false) ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <label>Общая площадь апартаментов (кв.м)</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form->field($model, 'square')->textInput(['type' => 'number'])->label(false) ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <label>Максимальное количество гостей</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form
                                ->field($model, 'guest')
                                ->dropdownList(
                                        StayHelper::listNumber(1, $stay->getMaxGuest() + (empty($stay->rules->beds->adult_count) ? 0 : $stay->rules->beds->adult_count)),
                                        ['prompt' => ' -- ']
                                )
                                ->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'isDeposit')->checkbox(['id' => 'is-deposit'])->label('Требуете ли Вы с гостей страховой залог'); ?>
                        </div>
                    </div>
                    <span id="deposit-view" style="display: none;">
                        <div class="d-flex">
                        <div>
                            <label>Залоговая сумма (руб)</label>
                        </div>
                        <div class="ml-auto">
                            <?= $form->field($model, 'deposit')->textInput(['type' => 'number', 'id' => 'amount-deposit', 'min' => 0])->label(false) ?>
                        </div>
                    </div>
                    </span>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'access')->dropdownList(StayParams::listAccess(), ['prompt' => 'Выберите вариант'])->label('Как гости могут попасть в Ваш объект?'); ?>
                        </div>
                    </div>
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

