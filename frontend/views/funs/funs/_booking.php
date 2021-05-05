<?php


use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use yii\helpers\Html;

/* @var $fun Fun */
DatepickerAsset::register($this);
?>

<div class="card bg-booking-widget">
    <div class="card-body">
        <?= Html::beginForm(['funs/checkout/booking']); ?>
        <input type="hidden" id="number-fun" name="fun-id" value="<?= $fun->id ?>">
        <label for="datepicker-fun"><b><?= Lang::t('Выберите дату') ?></b></label>
        <div class="input-group date pb-2" id="datepicker-fun" data-lang="<?= Lang::current() ?>">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
        </div>
        <div class="list-times"></div>
        <p></p>
        <?= BtnBooking::widget(['caption' => 'Забронировать', 'confirmation' => $fun->isConfirmation(), 'btn_id' => 'button-booking-fun']) ?>
    </div>
</div>
