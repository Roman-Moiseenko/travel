<?php

use booking\entities\booking\tours\BookingTour;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Url;

/* @var $bookings BookingTour[] */

?>
<span style="font-size: larger; font-weight: bold"> </span>
<?php if (isset($bookings) && count($bookings) > 0): ?>
    <div class="row">
        <div class="col d-flex">
        <div class="ml-auto booking-item">
        <a class="link-admin" href="<?= Url::to(['/cabinet/dialog/mass-tour', 'id' => null]) ?>"
           title="Написать сообщение">
            Написать всем <i class="fas fa-shipping-fast"></i>
        </a>
            </div>
        </div>
    </div>
    <?php foreach ($bookings as $i => $booking): ?>
        <div class="card">
            <div class="card-header p-0">
            <span class="booking-item">
                <?php if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_PAY): ?>
                    <span class="badge badge-pill badge-success" title=""><i class="far fa-check-circle"></i></span>
                <?php elseif ($booking->getStatus() == BookingHelper::BOOKING_STATUS_NEW): ?>
                    <span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i></span>
                <?php elseif ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CONFIRMATION): ?>
                    <span class="badge badge-pill badge-info"><i class="far fa-check-circle"></i></span>
                <?php elseif ($booking->isCancel()): ?>
                    <span class="badge badge-pill badge-secondary"><i class="far fa-check-circle"></i></span>
                <?php endif ?>
                </span>
                <span class="booking-item"  style="<?= ($booking->isCancel()) ? 'text-decoration: line-through !important' : ''?>">
                <a class="link-admin" data-toggle="collapse" href="#collapse-<?= $i ?>" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-user"></i>&#160;&#160;<?= empty($booking->user->personal->fullname->surname) ? $booking->user->username : $booking->user->personal->fullname->getFullname(); ?>
                </a>
                </span>
                <span class="booking-item">
                    <a href="<?= Url::to(['/cabinet/dialog/dialog', 'id' => BookingHelper::number($booking)]) ?>"
                       title="Написать сообщение"><i class="fas fa-shipping-fast"></i></a>
                </span>
            </div>
            <div class="collapse" id="collapse-<?= $i ?>">
                <div class="card-body">
                <span class="booking-item">
                    <i class="fas fa-bookmark"></i>&#160;&#160;<?= BookingHelper::number($booking); ?>
                </span>
                    <span class="booking-item">
                    <i class="fas fa-key"></i>&#160;&#160;<?= $booking->getPinCode(); ?>
                </span>
                    <span class="booking-item">
                    <i class="fas fa-phone"></i>&#160;&#160;<?= $booking->user->personal->phone; ?>
                </span>
                    <br>
                    <span class="booking-item">
                    <i class="fas fa-money-bill-alt"></i>&#160;&#160;<?= CurrencyHelper::get($booking->getAmountPayAdmin()); ?>
                        <?php if ($booking->discount) echo ' (' . $booking->discount->promo . ')' ?>
                </span>
                    <span class="booking-item">
                    <i class="fas fa-ticket-alt"></i>&#160;&#160;<?= $booking->count->adult + $booking->count->child + $booking->count->preference; ?>
                </span>
                    <span class="booking-item">
                    <i class="far fa-clock"></i>&#160;&#160;<?= date('d-m-Y', $booking->created_at); ?>
                </span>
                    <br>
                    <?php if (!$booking->isCancel()): ?>
                        <span class="booking-item">
                        <?php if ($booking->give_out): ?>
                            <label class="" for="giv-out-<?= $i ?>">выдано:</label>
                            <?php if ($booking->give_user_id == null) {
                                echo 'Администратором';
                            } else {
                                echo $booking->checkUser->fullname . '<br>Касса: ' . $booking->checkUser->box_office . '<br>Время: ' . date('d-m-Y H:i:s', $booking->give_at);
                            } ?>
                        <?php else: ?>
                            <span class="custom-control custom-checkbox">
                                <input id="giv-out-<?= $i ?>" class="custom-control-input give-out-car" type="checkbox" value="1"
                                       data-number="<?= BookingHelper::number($booking); ?>" <?= $booking->give_out ? 'disabled checked' : '' ?>>
                                <label class="custom-control-label" for="giv-out-<?= $i ?>">выдать</label>
                            </span>
                            <span id="error-set-give-<?= $i ?>"></span>
                        <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

