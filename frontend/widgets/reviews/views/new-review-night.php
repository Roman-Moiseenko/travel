<?php
/* @var $reviewForm \booking\forms\booking\ReviewForm */
/* @var $id int */
/* @var $action string */

use booking\entities\Lang;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\design\BtnReview;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6">
        <?= BtnReview::widget(['caption' => 'Оставить комментарий', 'target_id' => 'collapse-review'])?>
    </div>
</div>

<div class="collapse pt-4" id="collapse-review">
    <?php $form = ActiveForm::begin(['action' => $action]) ?>
    <div class="row">
        <div class="col-md-6 col-sm-12">
    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label(Lang::t('Комментарий') . ':'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <?= BtnSend::widget(['caption' => 'Отправить'])?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
