<?php


use booking\entities\message\Dialog;
use booking\helpers\MessageHelper;
use yii\helpers\Url;

$count = MessageHelper::countNewSupport();
if ($count > 0) {$message_count = $count  . ' сообщений';} else {$message_count = 'Новых сообщений нет';}
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-envelope"></i>
        <span class="badge badge-info navbar-badge"><?= $count   ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= $message_count ?></span>
        <div class="dropdown-divider"></div>


        <a href="<?= Url::to(['/dialogs/provider'])?>" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i><span class="badge badge-danger"><?= MessageHelper::countNewSupportByType(Dialog::PROVIDER_SUPPORT) ?></span> Сообщений от провайдеров
        </a>
        <a href="<?= Url::to(['/dialogs/client'])?>" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i><span class="badge badge-danger"><?= MessageHelper::countNewSupportByType(Dialog::CLIENT_SUPPORT) ?></span> Сообщений от клиентов
        </a>

    </div>
</li>
