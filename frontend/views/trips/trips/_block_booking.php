<?php


use booking\entities\booking\trips\Trip;
use booking\entities\Lang;
use booking\helpers\ReviewHelper;
use booking\helpers\SysHelper;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;

/* @var $trip Trip */
DatepickerAsset::register($this);
?>

<div class="row">
    <div class="col">
        <?php if ($trip->isActive()): ?>
            <div class="card bg-booking-widget">
                <div class="card-body">
                    <input type="hidden" id="number-trip" value="<?= $trip->id ?>">
                    <?= Html::beginForm(['trip/checkout/booking']); ?>
                    <label for="datepicker-trip"><b><?= Lang::t('Выберите дату') ?></b></label>
                    <div class="input-group date pb-2" id="datepicker-trip" data-lang="<?= Lang::current() ?>">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                        </div>
                        <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
                    </div>

                    <p></p>
                    <?= BtnBooking::widget([
                        'caption' => 'Забронировать',
                        'confirmation' => $trip->isConfirmation(),
                        'btn_id' => 'button-booking-trip',
                    ]) ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        <?php else: ?>
            <span class="badge badge-danger"
                  style="font-size: 16px"><?= Lang::t('Тур не активен!') ?><p></p><?= Lang::t('Бронирование недоступно!') ?></span>

        <?php endif; ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $trip->rating]); ?>
                <a href="#review">
                    <?= ReviewHelper::text($trip->reviews) ?>
                </a>
            </p>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= LegalWidget::widget(['legal' => $trip->legal]) ?>
    </div>
</div>
