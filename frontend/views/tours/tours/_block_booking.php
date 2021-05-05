<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;

/* @var $tour Tour */
DatepickerAsset::register($this);
?>

<div class="row">
    <div class="col">
        <?php if ($tour->isActive()): ?>
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
                    <?= BtnBooking::widget(['caption' => 'Забронировать', 'confirmation' => $tour->isConfirmation(), 'btn_id' => 'button-booking-tour']) ?>
                    <div class="pt-3" style="color: #560005; ">* <?= Lang::t('При покупке экскурсии менее чем за 7 дней, предварительно уточните ее доступность') ?></div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        <?php else: ?>
            <span class="badge badge-danger" style="font-size: 16px"><?= Lang::t('Тур не активен.') ?><p></p><?= Lang::t('Бронирование недоступно.') ?></span>

        <?php endif; ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $tour->rating]); ?>
                <a href="#review">
                    <?= $tour->countReviews() ?> <?= Lang::t('отзывов') ?>
                </a>
            </p>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= LegalWidget::widget(['legal' => $tour->legal]) ?>
    </div>
</div>
