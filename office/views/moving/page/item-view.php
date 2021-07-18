<?php

use booking\entities\moving\Item;
use booking\entities\moving\Page;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $page Page|null */
/* @var $item Item */

$this->title = $item->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['moving/page/view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['moving/page/items', 'id' => $page->id]];
$this->params['breadcrumbs'][] = $item->title;
?>
<p>
    <?= Html::a('Редактировать', ['item-update', 'id' => $page->id, 'item_id' => $item->id], ['class' => 'btn btn-success']) ?>

</p>
<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <ul class="thumbnails">
            <?php foreach ($item->photos as $i => $photo): ?>
                <li class="image-additional"><a class="thumbnail"
                                                href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                target="_blank">
                        <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= $item->title; ?>"/>
                    </a></li>
            <?php endforeach; ?>
        </ul>
        <?= Yii::$app->formatter->asHtml($item->text, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Расположение</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $item->address->address?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $item->address->latitude?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $item->address->longitude?>" disabled>
            </div>
        </div>

        <div class="row">
            <div id="map-view" style="width: 100%; height: 400px"></div>
        </div>
    </div>
</div>
