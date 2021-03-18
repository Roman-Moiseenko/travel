<?php

use booking\entities\booking\cars\CostCalendar;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Url;

/* @var $calendar CostCalendar */
/* @var $view_cancel bool */
?>
<?php if (isset($calendar->bookings) && count($calendar->bookings) > 0): ?>

    <div class="row">
        <div class="col d-flex">
            <div class="ml-auto booking-item">
                <a class="link-admin" href="<?= Url::to(['/cabinet/dialog/mass-car', 'id' => $calendar->id]) ?>"
                   title="Написать сообщение">
                    Написать всем <i class="fas fa-shipping-fast"></i>
                </a>
            </div>
        </div>
    </div>
    <?php foreach ($calendar->bookings as $i => $booking): ?>
    <?php if ($view_cancel == false && $booking->isCancel()) continue; ?>
        <div class="card">
            <div class="card-header p-0">
            <span class="booking-item">
                <?php if ($booking->isPay()): ?>
                    <span class="badge badge-pill badge-success" title="eeee"><i class="far fa-check-circle"></i></span>
                <?php elseif ($booking->isNew()): ?>
                    <span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i></span>
                <?php elseif ($booking->isConfirmation()): ?>
                    <span class="badge badge-pill badge-info"><i class="far fa-check-circle"></i></span>
                <?php elseif ($booking->isCancel()): ?>
                    <span class="badge badge-pill badge-secondary"><i class="far fa-check-circle"></i></span>
                <?php endif ?>
                </span>
                <span class="booking-item">
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

                    <span class="booking-item">
                    <i class="fas fa-money-bill-alt"></i>&#160;&#160;<?= CurrencyHelper::get($booking->getPayment()->getPrepay()) . ' (' . $booking->getPayment()->percent . '%)'; ?>
                </span>
                    <span class="booking-item">
                    <i class="fas fa-car"></i>&#160;&#160;<?= $booking->count; ?>
                </span>
                    <br>
                    <span class="booking-item">
                    <i class="far fa-clock"></i>&#160;&#160;<?= (($booking->end_at - $booking->begin_at) / (24 * 3600) + 1) . ' дней ' . 'с ' . date('d-m-Y', $booking->begin_at) . ' по ' . date('d-m-Y', $booking->end_at); ?>
                </span>

                    <?php if ($booking->delivery): ?>
                        <br>
                        <span class="booking-item">
                        <i class="fas fa-truck"></i>&#160;&#160;<?= $booking->comment ?>
                    </span>
                    <?php endif; ?>
                    <br>
                    <?php if ($booking->isPay() || $booking->isConfirmation()): ?>
                        <span class="booking-item">
                        <?php if ($booking->give_out): ?>
                            <label class="" for="giv-out-<?= $i ?>">выдано: </label>
                            <?php if ($booking->give_user_id == null) {
                                echo 'Администратором';
                            } else {
                                echo $booking->checkUser->fullname . '<br>Касса: ' . $booking->checkUser->box_office . '<br>Время: ' . date('d-m-Y H:i:s', $booking->give_at);
                            } ?>
                        <?php else: ?>
                            <span class="custom-control custom-checkbox">
                                <input id="giv-out-<?= $i ?>" class="custom-control-input give-out-car" type="checkbox"
                                       value="1"
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

