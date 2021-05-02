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
        <input type="hidden" id="number-tour" value="<?= $tour->id ?>" data-private="<?= $tour->params->private ?>">
        <?= Html::beginForm(['tours/checkout/booking']); ?>
        <label for="datepicker-tour"><b><?= Lang::t('Выберите дату') ?></b></label>
        <div class="input-group date pb-2" id="datepicker-tour" data-lang="<?= Lang::current() ?>">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
        </div>
        <div class="list-tours"></div>
        <p></p>
        <div class="d2-btn-box">
            <button class="d2-btn d2-btn-block d2-btn-buy" type="submit" id="button-booking-tour" disabled>
                <?= $tour->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести')?>
                <div class="d2-btn-icon">
                    <i class="far fa-credit-card"></i>
                </div>
            </button>
            <?= '' /*Html::submitButton(
                $tour->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести'),
                [
                    'class' =>  'btn btn-lg btn-primary btn-block',
                    'disabled' => 'disabled',
                    'id' => 'button-booking-tour'
                ]
            ) */?>
        </div>
        <span style="color: #560005; ">* <?= Lang::t('При покупке экскурсии менее чем за 7 дней, предварительно уточните ее доступность') ?></span>
        <?= Html::endForm() ?>
    </div>
</div>
