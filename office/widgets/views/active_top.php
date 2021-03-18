<?php

use yii\helpers\Url;


/* @var $objects array */
/* @var $count int */
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-success navbar-badge"><?= $count ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= $count ?> объектов</span>
        <?php foreach ($objects as $object): ?>
            <div class="dropdown-divider"></div>
            <div class="">
                <a href="<?= $object['link'] ?>" class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            <img src="<?= $object['photo'] ?>" alt="<?= $object['name'] ?>">
                        </div>
                        <div class="px-1 align-content-center">
                            <span style="white-space: pre-wrap !important; font-size: 12px; font-weight: 500;"> <?= $object['name'] ?> </span>
                        </div>
                        <div class="ml-auto">
                            <span class="float-right text-muted text-sm"><?= $object['created_at'] ?> </span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <a href="<?= Url::to(['active/index'])?>" class="dropdown-item dropdown-footer">Активация объектов</a>
    </div>
</li>
