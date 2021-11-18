<?php

use booking\entities\art\event\Event;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;


/* @var $event Event */

$url = Url::to(['art/event/event', 'slug' => $event->slug]);
$mobile = SysHelper::isMobile();
?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($event->photo): ?>
        <a href="<?= Html::encode($url) ?>">
            <div itemscope itemtype="https://schema.org/ImageObject">
                <div class="item-responsive <?= $mobile ? 'item-2-0by1' : 'item-2-0by3' //'item-1-1by1'?>">
                    <div class="content-item">
                        <a href="<?= Html::encode($url) ?>">
                            <img loading="lazy" src="<?= Html::encode($event->getThumbFileUrl('photo', $mobile ? 'catalog_list_mobile' : 'catalog_list_2_3x')) ?>"
                                 alt="<?= $event->title ?>"
                                 title="<?= $event->title ?>"
                                 class="card-img-top lazyload"/>
                            <link  itemprop="contentUrl" href="<?= Html::encode($event->getThumbFileUrl('photo', $mobile ? 'catalog_list_mobile' : 'catalog_list_2_3x')) ?>">
                        </a>
                    </div>
                </div>
                <meta itemprop="name"
                      content="<?= $event->title ?>">
                <meta itemprop="description" content="<?= $event->name ?>">
            </div>
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object" style="font-size: 16px !important;"><?= $event->name ?></h2>
        </a>
        <p class="card-text" style="height: available">
        <div style="font-size: 14px; padding-top: 4px;"><i class="fas fa-calendar-day"></i> <?= $event->getLastDate() ?></div>
        <div style="font-size: 14px; padding-top: 4px;"><i class="fas fa-map-marked-alt"></i> <?= $event->getLastAddress() ?></div>

        </p>
    </div>
    <div class="card-footer color-card-body">
        <?php foreach ($event->categories as $category): ?>
            <a href="<?= Url::to(['/art/event/category', 'slug' => $category->slug]) ?>"><?= $category->name ?></a>&#160;|&#160;
        <?php endforeach; ?>
        <a href="<?= Url::to(['/art/event/category', 'slug' => $event->category->slug]) ?>"><?= $event->category->name ?></a>
    </div>

    <a href="<?= Html::encode($url) ?>">
        <div class="mt-auto card-footer color-card-footer">
            <div class="d-flex">
                <div class="p-2">
                    <div class="price-card"><?= CurrencyHelper::get($event->cost) ?></div>
                </div>
            </div>
        </div>
    </a>
</div>