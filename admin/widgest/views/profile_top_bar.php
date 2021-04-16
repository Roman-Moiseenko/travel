<?php

/* @var $user \booking\entities\admin\User */
/* @var $userImage string */
/* @var $userName string */

use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<li class="nav-item dropdown user-menu hidden-for-large-down">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?= $userImage; ?>" class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline"><?= $userName; ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-primary">
            <img src="<?= $userImage; ?>" class="img-circle elevation-2" alt="User Image">

            <p>
                <?= $user->personal->fullname->getFullname(); ?>
                <small><?= date('Y-m-d', $user->created_at)?></small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-4 text-center">
                    <a href="#"></a>
                </div>
                <div class="col-4 text-center">
                    <a href="#"></a>
                </div>
                <div class="col-4 text-center">
                    <a href="#"></a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <a href="<?= Url::to(['cabinet/profile'])?>" class="btn btn-default btn-flat">Кабинет</a>
            <?= Html::a('Выйти', Url::to(['/logout']), ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
        </li>
    </ul>
</li>
<li class="nav-item user-menu">
    <a href="<?= Url::to(['/balance'])?>" class="nav-link"><?= CurrencyHelper::stat($user->Balance())?></a>
</li>