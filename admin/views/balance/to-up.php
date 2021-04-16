<?php

use booking\entities\booking\BaseBooking;
use booking\forms\admin\ToUpBalanceForm;
use booking\forms\booking\ConfirmationForm;
use booking\entities\Lang;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model ToUpBalanceForm */

$this->title = 'Пополнение баланса';
$this->params['breadcrumbs'][] = ['label' => Lang::t('Баланс'), 'url' => Url::to(['/balance'])];
$this->params['breadcrumbs'][] = $this->title;
?>
    <p class="pt-5"></p>

<?php $form = ActiveForm::begin([]); ?>
    <div class="row pt-5">
        <div class="col-md-5">

        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'amount')->textInput()->label(Lang::t('Сумма платежа')); ?>
            <div class="form-group">
                <?= Html::submitButton(Lang::t('К оплате'), ['class' => 'btn form-control btn-success']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>