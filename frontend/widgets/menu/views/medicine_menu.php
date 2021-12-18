<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $categories booking\entities\medicine\Page[] */
?>
<div class="container">
    <nav id="top-menu" class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="top-menu-a mt-1 nav-link"
                       href="<?= Html::encode(Url::to(['/'])) ?>" title="<?= Lang::t('На главную') ?>">
                        <i class="fas fa-bars"></i>&#160;
                    </a>
                </li>

                <?php foreach ($categories as $category):?>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= $this->params['slug'] == $category->slug ? 'active' : '' ?>"
                       href="<?= Url::to(['medicine/medicine/view', 'slug' => $category->slug])?>">
                        <?= $category->icon ?>&#160;<?= Lang::t($category->name) ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li class="nav-item">
                    <a class="top-menu-a nav-link"
                       href="<?= Html::encode(Url::to(['/forum/lechenie'])) ?>">
                        <i class="far fa-question-circle"></i>&#160;<?= Lang::t('Форум') ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

