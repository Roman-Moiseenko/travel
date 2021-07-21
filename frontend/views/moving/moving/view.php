<?php

use booking\entities\Lang;
use booking\entities\moving\Page;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapPageItemAsset;
use frontend\assets\MapStayAsset;
use frontend\assets\MovingAsset;
use frontend\widgets\moving\MenuPagesWidget;
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

//MagnificPopupAsset::register($this);
//MapPageItemAsset::register($this);
/*$js_click = <<<JS
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
$this->registerJs($js_click);*/


$this->params['canonical'] = Url::to(['moving/moving/view', 'slug' => $page->slug], true);
$this->params['pages'] = true;
$this->params['slug'] = $page->slug;
if (!$main_page) $this->params['breadcrumbs'][] = ['label' => 'Переезд на ПМЖ', 'url' => Url::to(['/moving'])];
foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => Url::to(['moving/moving/view', 'slug' => $parent->slug])];
    }
}
$this->params['breadcrumbs'][] = $page->name;
$mobile = SysHelper::isMobile();
?>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<span id="data-page" data-id="<?= $page->id ?>"></span>
<?= ''/*
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
]);*/
?>
<h1 class="pb-4"><?= $page->title ?></h1>
<article class="page-view params-moving <?= $mobile ? 'word-break-table'  : ''?>">

    <?= SysHelper::lazyloaded($page->content); ?>
    <ul>
        <?php foreach ($page->items as $i => $item): ?>
            <li><a href="#i-<?= $item->id ?>"><?= $item->title ?></a></li>
        <?php endforeach; ?>
    </ul>


</article>
<?= MenuPagesWidget::widget(['pages' => $categories]) ?>



<div id="map-item" style="display: none; height: 100%;"></div>
