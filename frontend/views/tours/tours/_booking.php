<?php


use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use frontend\assets\CalendarAsset;
use frontend\assets\DatepickerAsset;
use yii\helpers\Html;

/* @var $tour Tour */
DatepickerAsset::register($this);
?>

<div class="card bg-booking-widget">

    <div class="card-body">
        <input type="hidden" id="number-tour" value="<?= $tour->id ?>">
        <?= Html::beginForm(['tours/checkout/booking']); ?>
        <label for="datepicker-tour"><b><?= Lang::t('Выберите дату') ?></b></label>
        <div class="input-group date pb-2" id="datepicker-tour" data-lang="<?= Lang::current() ?>">
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
        </div>
        <div class="list-tours"></div>
        <p></p>
        <div class="form-group">
            <?= Html::submitButton(
                $tour->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести'),
                [
                    'class' => 'btn btn-primary btn-lg btn-block',
                    'disabled' => 'disabled',
                    'id' => 'button-booking-tour'
                ]
            ) ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
