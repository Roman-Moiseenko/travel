<?php

use booking\entities\booking\BookingItemInterface;
use booking\helpers\MessageHelper;
use yii\helpers\Url;

/* @var $dialogs array */
/* @var $bookings BookingItemInterface */

$count = MessageHelper::countNew();
if ($count > 0) {$message_count = $count  . ' сообщений';} else {$message_count = 'Новых сообщений нет';}
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-envelope"></i>
        <span class="badge badge-info navbar-badge"><?= $count ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= $message_count ?></span>
        <div class="dropdown-divider"></div>
        <?php foreach ($dialogs as $id => $item): ?>
        <a href="<?= Url::to(['cabinet/dialog/conversation', 'id' => $id])?>" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i><span class="badge badge-danger"><?= $item['count'] ?></span> <?= $item['theme'] ?>
        </a>
        <?php endforeach; ?>
        <a href="<?= Url::to(['cabinet/dialog'])?>" class="dropdown-item">Все сообщения</a>
    </div>
</li>
