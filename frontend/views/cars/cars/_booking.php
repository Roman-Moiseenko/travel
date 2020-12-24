<?php

use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use yii\helpers\Html;

/* @var $car Car */
DatepickerAsset::register($this);
?>

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
                        <div class="input-group-text"><span class="glyphicon glyphicon-calendar"></span></div>
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
        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block" id="button-booking-car" disabled><?= $car->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести') ?></button>
        </div>
    </div>
</div>
