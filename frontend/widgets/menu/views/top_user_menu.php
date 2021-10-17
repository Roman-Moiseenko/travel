<?php

use booking\entities\Lang;
use booking\entities\user\User;
use booking\helpers\CurrencyHelper;
use booking\helpers\MessageHelper;
use frontend\widgets\shop\CartWidget;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $user \booking\entities\user\User|null */

/* @var $user User */



?>
<div class="container">
    <div id="top-links">
        <ul class="nav justify-content-end">
            <li class="nav-item mr-auto" style="color: #0f455a; font-weight: 600"><a class="nav-link" href="<?= Url::to(['/'], true) ?>"><i class="fab fa-fort-awesome-alt"></i> Калининград для туристов и гостей</a></li>
            <li class="nav-item">
                    <span class="hidden-xs hidden-sm hidden-md">
                        <a class="nav-link" href="<?= Url::to(['/cabinet/dialogs']) ?>"
                           title="<?= Lang::t('Сообщения') ?>" rel="nofollow">
                            <i class="fas fa-envelope"></i><span
                                class="badge badge-danger"><?= MessageHelper::countNew() ?></span>
                        </a>
                    </span>
            </li>
            <!--li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false" rel="nofollow">
                    <?= Lang::current() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (Lang::listLangs() as $lang): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/', 'lang' => $lang])) ?>" rel="nofollow"><?= $lang ?></a>
                    <?php endforeach; ?>
                </div>
            </li-->
            <li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link"
                   data-toggle="dropdown" rel="nofollow"><?= CurrencyHelper::currentString() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (CurrencyHelper::listCurrency() as $key => $currency): ?>
                        <a class="dropdown-item" rel="nofollow"
                           href="<?= Html::encode(Url::to(['/cabinet/user/currency', 'currency' => $key])) ?>">
                            <?= $currency ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="nav-item">
                <span class="hidden-xs hidden-sm hidden-md">
                    <a class="nav-link" href="<?= Url::to(['/support']) ?>" title="<?= Lang::t('Служба поддержки') ?>" rel="nofollow">
                        <i class="far fa-question-circle"></i>
                    </a>
                </span>
            </li>

            <?= CartWidget::widget()?>

            <li class="dropdown nav-item">
                <?php if ($user): ?>
                    <a href="" title="<?= Lang::t('Мой личный кабинет') ?>" class="dropdown-toggle nav-link" data-toggle="dropdown" rel="nofollow">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs hidden-sm hidden-md">
                        <?=  $user->personal->fullname->isEmpty() ? $user->username : $user->personal->fullname->firstname?>
                    </span> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                        <?= UserMenuWidget::widget([
                            'type' => UserMenuWidget::TOP_USERMENU,
                            'class_list' => 'dropdown-item',
                        ]) ?>
                    </div>
                <?php else: ?>
                    <a href="" title="<?= Lang::t('Войти') ?>" class="dropdown-toggle nav-link" data-toggle="dropdown" rel="nofollow"><i class="fas fa-sign-in-alt"></i> <?= Lang::t('Войти') ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/login'])) ?>" rel="nofollow"><?= Lang::t('Войти') ?></a>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/signup'])) ?>" rel="nofollow"><?= Lang::t('Регистрация') ?></a>
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>