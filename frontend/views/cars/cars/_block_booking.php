<?php

use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
/* @var $car Car */
DatepickerAsset::register($this);

?>
<div class="row">
    <div class="col">
        <?php if ($car->isActive()):?>
            <div class="card bg-booking-widget">
                <div class="card-body">
                    <input type="hidden" id="number-car" value="<?= $car->id ?>">
                    <div class="row">
                        <div class="col">
                            <label for="datepicker-car-from"><b><?= Lang::t('Выберите') ?></b></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 pr-1">
                            <div class="input-group date pb-2" id="datepicker-car-from" data-lang="<?= Lang::current() ?>">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                </div>
                                <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
                            </div>
                        </div>
                        <div class="col-4 px-1">
                            <div class="date pb-2" id="datepicker-car-to" data-lang="<?= Lang::current() ?>">
                                <input type="text" id="datepicker_value_end" value="" class="form-control" readonly/>
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <div class="col-2 pl-3">
                            <a class="input-group-text text-center" style="cursor: pointer;"><span id="clear-car-calendar"><i class="fas fa-window-close"></i></span></a>
                        </div>
                    </div>
                    <div id="rent-car"></div>
                    <p></p>
                    <?= BtnBooking::widget(['caption' => 'Забронировать', 'confirmation' => $car->isConfirmation(), 'btn_id' => 'button-booking-car']) ?>
                </div>
            </div>
        <?php else: ?>
            <span class="badge badge-danger" style="font-size: 16px"><?= Lang::t('Прокат не активен.') ?><p></p><?= Lang::t('Бронирование недоступно.') ?></span>

        <?php endif; ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $car->rating]); ?>
                <a href="#review">
                    <?= $car->countReviews() ?> <?= Lang::t('отзывов') ?>
                </a>
                &nbsp;
            </p>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= LegalWidget::widget(['legal' => $car->legal]) ?>
    </div>
</div>
