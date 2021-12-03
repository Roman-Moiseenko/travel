<?php

use booking\forms\realtor\BookingLandowner;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\ActiveForm;

/* @var $this \yii\web\View */
/* @var $action string */
/* @var $model BookingLandowner */
?>

<h2 class="pt-5">Предварительное бронирование осмотра участка</h2>
<p>
    Запишитесь на осмотр участка в удобное для Вас время. В заявке достаточно указать месяц, когда Вы сможете посетить
    Калининградскую область, и мы забронируем под Вас данную услугу.
</p>
<div class="row">
    <div class="col-md-9">
<div class="card" style="border-radius: 40px">
    <a href="#" data-toggle="collapse"
       data-target="#booking"
       aria-expanded="false" aria-controls="booking">
    <div class="card-header" style="border-radius: 40px">Заполнить заявку на осмотр участка</div>
    </a>
    <div class="collapse" id="booking">
    <div class="card-body" style="border-radius: 40px">
        <?php $form = ActiveForm::begin([
            'id' => 'booking-landowner',
            //'enableClientValidation' => false,
            'action' => $action,
        ]); ?>
        <div class="row">
            <?= $form->field($model, 'landowner_id')->textInput(['type' => 'hidden'])->label(false) ?>

            <div class="col-sm-6">
                <?= $form->field($model, 'name')->textInput(['placeholder' => 'ФИО'])->label(false) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'period')->textInput(['placeholder' => 'Укажите месяц и год посещения Калининграда'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон +7хххххххххх'])->label(false) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'wish')->textarea(['row' => 6, 'placeholder' => 'Пожелания'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <?= BtnSend::widget(['caption' => 'Отправить заявку', 'block' => false]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
</div>

<h2 class="pt-5">Подобрать индивидуально участок под ИЖС</h2>
<p>
    Если Вам не подошел этот проект, заполните анкету и мы вышлем еще несколько интересных и недорогих вариантов земельных участков под ИЖС
</p>
<?= BtnSend::widget([
    'caption' => 'Заполнить Анкету',
    'block' => false,
    'url' => 'https://forms.gle/KB64WCPFzGSVxG3g8',
]) ?>