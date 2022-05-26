<?php


/* @var $this \yii\web\View */

/* @var $menu array */

use yii\helpers\Html;
use yii\helpers\Url;

$script = <<<JS
$(document).ready(function() {
    $('#side-menu').prop('checked', false);
    $('.dropdown-li').removeClass('current');
    $('#side-menu').on('click', function () {
        /** Show menu*/        
        if ($(this).is(':checked')) {
            $('.dropdown-li').removeClass('current');
            $('#menu-up-level').fadeIn();
        } else {
            $('#menu-up-level').fadeOut();
        }
    }
    );
    $('.side-menu-down').on('click', function () {
        let _parent = $(this).parent().parent();
        if (_parent.hasClass('current')) {
           $('.dropdown-li').removeClass('current');
        } else {
            $('.dropdown-li').removeClass('current');
            _parent.addClass('current');            
        }
    });
});
JS;
$this->registerJs($script);
?>
<style>


</style>
<div class="container-menu">

    <div class="navbar-desktop">
        <ul class="navbar-top">
            <li class="nav-item mr-auto">
                <a class="nav-link" href="<?= Url::to(['/'], true) ?>"
                   style="color: #0f455a; font-weight: 600; font-size: 12px;">
                    <i class="fab fa-fort-awesome-alt"></i>&#160;Калининград для туристов и гостей
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mailto:koenigs.ru@gmail.com" title="Написать нам" rel="nofollow">
                    <span class="landing-top-contact"><i class="far fa-envelope"></i></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://vk.com/koenigsru" target="_blank" rel="nofollow">
                    <span class="landing-top-contact"><i class="fab fa-vk"></i></span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav desktop">
            <?php foreach ($menu as $top_item): ?>
                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                    <a class="top-menu-a mt-1 nav-link" href="<?= $top_item['link'] ?>"
                       title="<?= $top_item['title'] ?>">
                        <?= $top_item['icon'] ?>&#160;<?= $top_item['title'] ?>
                    </a>
                    <?php if (isset($top_item['items'])): ?>
                        <ul class="dropdown-menu-nav" role="menu">
                            <?php foreach ($top_item['items'] as $item): ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                    <a title="<?= $item['title'] ?>" href="<?= $item['link'] ?>"
                                       class="dropdown-item-nav">
                                        <?= $item['icon'] ?> <?= $item['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="navbar-mobile">
        <ul class="navbar-top">
            <li class="nav-item mr-auto">
                <a class="nav-link" href="<?= Url::to(['/'], true) ?>"
                   style="color: #0f455a; font-weight: 600; font-size: 12px;">
                    <i class="fab fa-fort-awesome-alt"></i>&#160;Калининград для туристов и гостей
                </a>
            </li>
            <li class="nav-item">
                <input class="side-menu" type="checkbox" id="side-menu"/>
                <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
            </li>
        </ul>

        <ul id="menu-up-level" role="menu" class="navbar-nav mobile" style="display: none;">
            <?php foreach ($menu as $i => $top_item): ?>
                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                <?= (isset($top_item['items'])) ? 'class="dropdown-li"' : ''?> >

                    <a class="top-menu-a" href="<?= $top_item['link'] ?>"
                       title="<?= $top_item['title'] ?>">
                        <?= $top_item['icon'] ?>&#160;<?= $top_item['title'] ?>
                    </a>
                    <?php if (isset($top_item['items'])): ?>
                    <span>
                        <button type="button" class="fas fa-angle-right side-menu-down"></button>
                    </span>
                        <ul role="menu">
                            <?php foreach ($top_item['items'] as $item): ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                    <a title="<?= $item['title'] ?>" href="<?= $item['link'] ?>"
                                       class="dropdown-item-nav">
                                        <?= $item['icon'] ?> <?= $item['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

