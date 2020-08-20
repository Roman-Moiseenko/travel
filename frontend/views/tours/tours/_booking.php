<?php


use booking\entities\booking\tours\Tour;
use frontend\assets\DatepickerAsset;
use yii\helpers\Html;

/* @var $tour Tour */
DatepickerAsset::register($this);
?>

<div class="card bg-booking-widget">

    <div class="card-body">
        <input type="hidden" id="number-tour" value="<?= $tour->id ?>">
        <?= Html::beginForm(['tour/tour/booking']); ?>
        <div class="input-group date" id="datepicker-tour">
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control"/>
        </div>
        <div class="list-tours"></div>
        ДАТА (Календарь выпадающий с датами доступными только), ВРЕМЯ (список из Календаря),
        КОЛ-ВО оставшихся билетов, ЦЕНА по категориям, ПОЛЯ ввода Кол-ва билетов каждой категории
        <div class="form-group">
            <?= Html::submitButton('Приобрести', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
