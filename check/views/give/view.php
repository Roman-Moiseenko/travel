<?php

use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Url;

/* @var $bookings BookingItemInterface[] */
/* @var $name string */
/* @var $link_selling string */

$this->title = 'Выдача билетов';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="d-flex p-2 justify-content-center" style="background-color: #85c17c; color: #134b18; font-size: 26px; font-weight: 600; text-align:  center;">

        <?= '<a class="link-head" href="' . Url::to(['/give/index']). '"><i class="fas fa-reply"></i></a>&#160;' . $name .'&#160;<a class="link-head" href="' . $link_selling. '"><i class="fas fa-hand-holding-usd"></i></a> ' ?>
    </div>
<?php foreach ($bookings as $i => $booking): ?>
    <div class="card m-1">
        <div class="card-header p-1">
            <span class="booking-item">
                <a class="link-user<?= $booking->give_out ? '-give' : ''?>" data-toggle="collapse" href="#collapse-<?= $i ?>" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-user"></i>&#160;&#160;<?= empty($booking->user->personal->fullname->surname) ? $booking->user->username : $booking->user->personal->fullname->getFullname(); ?>
                </a>
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
                    <?= BookingHelper::icons($booking->getType())?>&#160;&#160;<?= '1' ?>
                </span>
                <br>
                <?php if (!$booking->give_out): ?>
                    <a class="btn btn-primary" href="<?= Url::to(['give/give', 'id' => $booking->id, 'type' => $booking->getType()])?>">Выдать</a>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php endforeach; ?>