<?php

/* @var $user booking\entities\admin\user\User */
/* @var $userImage string */
/* @var $userName string */
use yii\helpers\Url; ?>

<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?= $userImage; ?>" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="<?= Url::to(['cabinet/profile'])?>" class="d-block"><?= $userName; ?></a>
    </div>
</div>
