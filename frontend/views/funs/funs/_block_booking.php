<?php

use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;

/* @var $fun Fun */
DatepickerAsset::register($this);

?>

<div class="row">
    <div class="col">
        <?php if ($fun->isActive()): ?>
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
        <?php else: ?>
            <span class="badge badge-danger" style="font-size: 16px"><?= Lang::t('Мероприятие не активно.') ?><p></p><?= Lang::t('Бронирование недоступно.') ?></span>
        <?php endif; ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $fun->rating]); ?>
                <a href="#review">
                    <?= $fun->countReviews() ?> <?= Lang::t('отзывов') ?>
                </a>
            </p>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= LegalWidget::widget(['legal' => $fun->legal]) ?>
    </div>
</div>
