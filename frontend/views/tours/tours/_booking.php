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
        <div class="input-group" id="datepicker-tour">
            <input type="text" id="datepicker_value" value="" class="form-control"/>
            <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
        </div>
        ДАТА (Календарь выпадающий с датами доступными только), ВРЕМЯ (список из Календаря),
        КОЛ-ВО оставшихся билетов, ЦЕНА по категориям, ПОЛЯ ввода Кол-ва билетов каждой категории
        <div class="form-group">
            <?= Html::submitButton('Приобрести', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
