<?php

/* @var $sort_bookings array */

/* @var  $only_pay boolean */

use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Бронирования по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
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
                <div class="d-flex align-items-center">
                    <div>
                        <a class="btn btn-success" data-toggle="collapse" href="#collapse<?= $day ?>" role="button"
                           aria-expanded="false" aria-controls="collapse<?= $day ?>">
                            <h3><?= date('d-m-Y', $day) ?></h3></a>
                    </div>
                    <div class="pl-4">
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
                        <?= $count; ?> билета(ов) <br> <?= CurrencyHelper::get($amount); ?>
                    </div>
                </div>
            </div>
            <div class="collapse multi-collapse" id="collapse<?= $day ?>">
                <div class="card-body ml-5">
                    <?php foreach ($day_bookings as $time => $bookings): ?>
                        <div class="row">
                            <div class="d-flex align-items-center py-2">
                                <div>
                                    <h3 style="margin: 0 0"><span class="badge badge-primary"><?= $time ?></span></h3>
                                </div>
                                <div class="pl-3">
                                    <?php
                                    $count = 0;
                                    $amount = 0;
                                    foreach ($bookings as $booking) {
                                        $amount += $booking->getAmountPayAdmin();
                                        $count += $booking->count->adult + $booking->count->child + $booking->count->preference;
                                    }
                                    ?>
                                    Билетов <?= $count; ?> на сумму <?= CurrencyHelper::get($amount); ?>
                                </div>
                                <div class="pl-5">
                                    <a class="btn collapse-time" data-status="down" data-toggle="collapse"
                                       href="#collapse<?= $day . str_replace(':', '', $time) ?>" role="button"
                                       aria-expanded="false"
                                       aria-controls="collapse<?= $day . str_replace(':', '', $time) ?>"
                                       style="z-index: 9999">
                                        <i class="fas fa-chevron-down"></i></a>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <div class="collapse multi-collapse" id="collapse<?= $day . str_replace(':', '', $time) ?>">
                            <?php foreach ($bookings as $booking): ?>
                                <div class="row pl-2">
                                <span class="params-item">
                                <i class="fas fa-user"></i>&#160;&#160;<?= $booking->user->personal->fullname->getFullname(); ?>
                                </span>
                                    <span class="params-item">
                                    <i class="fas fa-money-bill-alt"></i>&#160;&#160;<?= CurrencyHelper::get($booking->getAmountPayAdmin()); ?>
                                        <?php if ($booking->discount) echo ' (' . $booking->discount->promo . ')' ?>
                                </span>
                                    <span class="params-item">
                                    <i class="fas fa-ticket-alt"></i>&#160;&#160;<?= $booking->count->adult + $booking->count->child + $booking->count->preference; ?>
                                </span>
                                    <span class="params-item">
                                <i class="fas fa-phone"></i>&#160;&#160;<?= $booking->user->personal->phone; ?>
                                </span>
                                    <span class="params-item">
                                <i class="far fa-clock"></i>&#160;&#160;<?= date('d-m-Y H:i', $booking->created_at); ?>
                                </span>
                                    <span class="params-item">
                                <i class="fas fa-bookmark"></i>&#160;&#160;<?= BookingHelper::number($booking); ?>
                                </span>
                                    <span class="params-item">
                                <i class="fas fa-key"></i>&#160;&#160;<?= $booking->getPinCode(); ?>
                                </span>
                                    <span class="params-item">
                                    <a href="<?= Url::to(['/cabinet/dialog/dialog', 'id' => BookingHelper::number($booking)]) ?>"
                                       title="Написать сообщение"><i class="fas fa-shipping-fast"></i></a>
                                </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>