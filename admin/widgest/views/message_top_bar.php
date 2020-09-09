<?php

use booking\entities\booking\BookingItemInterface;
use booking\helpers\MessageHelper;
use yii\helpers\Url;

/* @var $bookings BookingItemInterface */
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-envelope"></i>
        <span class="badge badge-info navbar-badge"><?= MessageHelper::countNew() ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= MessageHelper::countNew() ?> Сообщений</span>
        <div class="dropdown-divider"></div>
        <?php foreach ($dialogs as $id => $item): ?>
        <a href="<?= Url::to(['cabinet/dialog/conversation', 'id' => $id])?>" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i><span class="badge badge-danger"><?= $item['count'] ?></span> <?= $item['theme'] ?>
        </a>
        <?php endforeach; ?>
        </a>
    </div>
</li>
