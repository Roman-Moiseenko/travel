<?php

/* @var $user booking\entities\admin\user\User */
use yii\helpers\Url; ?>

<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?= ''//$user->getThumbFileUrl('file', 'catalog_product_main');?>" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="<?= Url::to(['cabinet/profile'])?>" class="d-block"><?= $user->username?></a>
    </div>
</div>
