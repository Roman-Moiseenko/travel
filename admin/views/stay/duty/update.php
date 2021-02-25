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
        //f(true);
        //$('#is-deposit').prop('checked', true);
    }
    
    $('body').on('click', '#is-deposit', function() {
       // f($(this).is(':checked'))
    });

    function f(_x) {
      if (_x){
          //$('#deposit-view').show();
      } else  {
          //$('#deposit-view').hide();
      }
    }
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

    <div class="card card-secondary">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">

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

