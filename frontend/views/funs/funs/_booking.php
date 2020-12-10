<?php


use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use frontend\assets\DatepickerAsset;
use yii\helpers\Html;

/* @var $fun Fun */
DatepickerAsset::register($this);
?>

<div class="card bg-booking-widget">

    <div class="card-body">

        <?= Html::beginForm(['funs/checkout/booking']); ?>
        <input type="hidden" id="number-fun" name="fun-id" value="<?= $fun->id ?>">
        <label for="datepicker-fun"><b><?= Lang::t('Выберите дату') ?></b></label>
        <div class="input-group date pb-2" id="datepicker-fun" data-lang="<?= Lang::current() ?>">
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
            <input type="text" id="datepicker_value" value="" class="form-control" readonly/>
        </div>
        <div class="list-times"></div>
        <p></p>
        <div class="form-group">
            <?= Html::submitButton(
                $fun->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести'),
                [
                    'class' => 'btn btn-primary btn-lg btn-block',
                    'disabled' => 'disabled',
                    'id' => 'button-booking-fun'
                ]
            ) ?>
        </div>
        <?= Html::endForm() ?>
        <?php if (\Yii::$app->user->isGuest): ?>
            <div class="card-footer">
                <?= Lang::t('Для бронирования зарегистрируйтесь на сайте') ?>.
            </div>
        <?php endif; ?>
    </div>
</div>