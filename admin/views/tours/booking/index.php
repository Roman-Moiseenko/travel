<?php

/* @var $sort_bookings array */

/* @var  $only_pay boolean */

use yii\bootstrap4\ActiveForm;

$this->title = 'Бронирования по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tours/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Бронирования';
?>
<?php $form = ActiveForm::begin() ?>
<div class="custom-control custom-checkbox">
    <input id="only_pay" class="custom-control-input" type="checkbox" name="only_pay" value="1"
           onclick="submit();" <?= $only_pay ? 'checked' : '' ?>>
    <label class="custom-control-label" for="only_pay">Только оплаченные</label>
</div>
<?php ActiveForm::end() ?>
<div class="tours-view">
    <?php foreach ($sort_bookings as $day => $day_bookings): ?>
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div>
                    <a class="btn btn-success" data-toggle="collapse" href="#collapse<?= $day ?>" role="button" aria-expanded="false" aria-controls="collapse<?= $day ?>">
                        <h2><?= date('d-m-Y', $day) ?></h2></a>
                </div>
                <div class="ml-auto">
                    <?php
                    $count = 0;
                    $amount = 0;
                    foreach ($day_bookings as $day_booking) {
                       foreach ($day_booking as $booking) {
                           $amount += $booking->getAmountPayAdmin();
                           $count += $booking->count->adult + $booking->count->child + $booking->count->preference;
                       }
                    }
                    ?>

                    Всего билетов <?= $count; ?>. Сумма <?= $amount; ?> руб
                </div>
            </div>
        </div>
        <div class="collapse multi-collapse" id="collapse<?= $day ?>">
            <div class="card-body ml-5">
            <?php foreach ($day_bookings as $time => $bookings): ?>
                <div class="d-flex py-2">
                    <div><h3><span class="badge badge-primary"><?= $time ?></span></h3>
                    </div>
                    <div class="ml-auto">
                        <?php
                        $count = 0;
                        $amount = 0;
                        foreach ($bookings as $booking) {
                                $amount += $booking->getAmountPayAdmin();
                                $count += $booking->count->adult + $booking->count->child + $booking->count->preference;
                        }
                        ?>
                        Всего билетов <?= $count; ?>. Сумма <?= $amount; ?> руб

                    </div>
                </div>
                <hr/>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

Показать ближащие бронирования:<br>
Дата 1. <br>
. . Время. Кол-во билетов. Сумма <br>
. . . . Список Туристов - Ф.И.О. Кол-во билетов. Сумма<br>
. . . . Написать сообщение. № телефона.<br>

...<br>
Дата N. <br>