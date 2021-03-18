<?php

use booking\entities\booking\BaseBooking;

/* @var $bookings BaseBooking */
/* @var $count int */
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-success navbar-badge"><?= $count ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= $count ?> Бронирований</span>
        <?php foreach ($bookings as $key => $booking): ?>
            <div class="dropdown-divider"></div>
            <div class="">
                <a href="<?= $booking['link'] ?>" class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            <img src="<?= $booking['photo'] ?>" alt="<?= $booking['name'] ?>">
                        </div>
                        <div class="px-1 align-content-center">
                            <span style="white-space: pre-wrap !important; font-size: 12px; font-weight: 500;"> <?= $booking['name'] ?> </span>
                        </div>
                        <div class="ml-auto">
                            <span class="float-right text-muted text-sm"><?= $booking['count'] ?></span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <span class="dropdown-item dropdown-footer"></span>
    </div>
</li>
