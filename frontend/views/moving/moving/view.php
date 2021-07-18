<?php

use booking\entities\Lang;
use booking\entities\moving\Page;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapPageItemAsset;
use frontend\assets\MapStayAsset;
use frontend\assets\MovingAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page Page */
/* @var $categories Page[] */
/* @var $main_page bool */

$this->title = Lang::t($page->getSeoTitle());

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);

MagnificPopupAsset::register($this);
MapPageItemAsset::register($this);
$js_click = <<<JS
$(document).ready(function() {
$('.fancybox-close').click(function(e){
    e.preventDefault();
    //history.pushState({}, '', '');
    });
$('.map-close').click(function(e){
    e.preventDefault();
    //history.pushState({}, '', '');
    });
});
JS;
$this->registerJs($js_click);


$this->params['canonical'] = Url::to(['moving/moving/view', 'slug' => $page->slug], true);
$this->params['pages'] = true;
$this->params['slug'] = $page->slug;
if (!$main_page) $this->params['breadcrumbs'][] = ['label' => 'Переезд на ПМЖ', 'url' => Url::to(['/moving'])];
foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => Url::to(['moving/moving/view', 'slug' => $parent->slug])];
    }
}
$this->params['breadcrumbs'][] = $page->title;
$mobile = SysHelper::isMobile();
?>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<span id="data-page" data-id="<?= $page->id ?>"></span>
<?=
newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => false,
    'mouse' => true,
    'config' => [
        'maxWidth' => '95%',
        'maxHeight' => '95%',
        'playSpeed' => 0,
        'arrows' => false,
        'padding' => 0,
        'fitToView' => false,
        'width' => '90%',
        'height' => '90%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'none',
        'closeEffect' => 'none',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => true,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'inline'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.3)'
                ]
            ]
        ],
    ]
]);
?>
<div class="d-flex flex-wrap">
    <?php foreach ($categories as $category): ?>
        <a href="<?= Url::to(['moving/moving/view', 'slug' => $category->slug]) ?>">
            <div class="flex-fill moving-menu-page m-1 align-self-center"> <?= $category->title ?></div>
        </a>
    <?php endforeach; ?>
</div>
<article class="page-view params-moving">
    <?= SysHelper::lazyloaded($page->content); ?>
    <ul>
        <?php foreach ($page->items as $i => $item): ?>
            <li><a href="#i-<?= $item->id ?>"><?= $item->title ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php foreach ($page->items as $i => $item): ?>
        <h2 class="pt-4 pb-1" id="i-<?= $item->id ?>"><?= $item->title ?></h2>
        <div class="pb-3">
            <ul class="thumbnails">
                <?php foreach ($item->photos as $i => $photo): ?>
                    <?php if ($i == 0): ?>
                        <li>
                            <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <div class="item-responsive item-2-0by1">
                                    <div class="content-item">
                                        <img src="<?= $photo->getThumbFileUrl('file', 'catalog_gallery'); ?>"
                                             alt="<?= Html::encode($item->title) . ' Фото #1' ?>" width="100%"
                                             loading="lazy"/>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="image-additional">
                            <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">&nbsp;
                                <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                     alt="<?= Html::encode($item->title) . ' Фото #' . ($i + 1) ?>" loading="lazy"
                                     height="70px"/>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php if ($item->address->address): ?>
            <a href="#map-item" id="a-map-item-<?= $i ?>" title="" rel="fancybox" class="loader_ymap a-map-item"
               data-item="<?= $item->id ?>"
               data-zoom="16"
               data-longitude="<?= $item->address->longitude ?>"
               data-latitude="<?= $item->address->latitude ?>"
               data-name="<?= $item->title ?>"
            >
                <i class="fas fa-map-marker-alt"></i> <?= $item->address->address ?>
            </a>

        <?php endif ?>
    <div class="pt-3 pb-2">
        <?= SysHelper::lazyloaded($item->text); ?>
    </div>
    <?php endforeach; ?>
</article>


<div id="map-item" style="display: none; height: 100%;"></div>
