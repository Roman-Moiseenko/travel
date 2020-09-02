<?php


use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use yii\helpers\Html;

/* @var $tour Tour */
DatepickerAsset::register($this);
?>

<div class="card bg-booking-widget">

    <div class="card-body">
        <input type="hidden" id="number-tour" value="<?= $tour->id ?>">
        <?= Html::beginForm(['tours/checkout/booking']); ?>
        <label for="datepicker-tour"><?= Lang::t('Выберите дату') ?></label>
        <div class="input-group date pb-2" id="datepicker-tour">
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
        </div>
        <div class="list-tours"></div>
        <p></p>
        <div class="form-group">
            <?= Html::submitButton(
                Lang::t('Приобрести'),
                [
                    'class' => 'btn btn-primary btn-lg btn-block',
                    'disabled' => 'disabled',
                    'id' => 'button-booking-tour'
                ]
            ) ?>
        </div>
        <?= Html::endForm() ?>
        <?php if (\Yii::$app->user->isGuest): ?>
            <div class="card-footer">
                <?= Lang::t('Для приобретения билетов, зарергистрируйтесь на сайте') ?>.
            </div>
        <?php endif; ?>
    </div>
</div>