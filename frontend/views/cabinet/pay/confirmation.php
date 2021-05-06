<?php

use booking\entities\booking\BaseBooking;
use booking\forms\booking\ConfirmationForm;
use booking\entities\Lang;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\design\BtnConfirmation;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model ConfirmationForm */
/* @var $booking BaseBooking */

$this->title = Lang::t('Подтверждение бронирования');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];
$this->params['breadcrumbs'][] = ['label' => $booking->getName(), 'url' => $booking->getLinks()->frontend];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pt-5"></p>

<?php $form = ActiveForm::begin([]); ?>
<div class="row pt-5">
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'confirmation')->textInput()->label(Lang::t('Код подтверждения брони')); ?>
        <div class="form-group">
            <?= BtnConfirmation::widget([]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
