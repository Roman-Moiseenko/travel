<?php

use booking\entities\moving\Item;



/* @var $this \yii\web\View */
/* @var $page \booking\entities\moving\Page|null */
/* @var $model \booking\forms\moving\ItemForm */
/* @var $item Item */

$this->title = 'Редактировать Элемент - ' . $item->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['moving/page/view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['moving/page/items', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => $item->title, 'url' => ['moving/page/item', 'id' => $page->id, 'item_id' => $item->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="items-create">

    <?= $this->render('items-form', [
        'model' => $model,
        'item' => $item,
        'page' => $page,
    ]) ?>
</div>