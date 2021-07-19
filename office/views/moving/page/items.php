<?php

use booking\entities\moving\Page;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $page Page|null */

$this->title = 'Список Элементов - ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['moving/page/view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = 'Список Элементов';
\yii\web\YiiAsset::register($this);

?>
<p>
    <?= Html::a('Создать Элемент', ['item-create', 'id' => $page->id], ['class' => 'btn btn-warning']) ?>
</p>
<div class="card">
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <td></td>
            </tr>
            </thead>
            <?php foreach ($page->items as $item): ?>
                <tr>
                    <td>
                        <span style="font-size: 26px"><?= $item->title ?></span>
                        <?=
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['item-move-up', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['item-move-down', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['item-update', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['item', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-trash"></span>', ['item-delete', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]);
                        ?>
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
                        <div>
                            <?= $item->text ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


