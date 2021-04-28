<?php

use booking\entities\shops\Shop;
use booking\forms\shops\ProductForm;

/* @var $this yii\web\View */
/* @var $model ProductForm */
/* @var $shop Shop */

$this->title = 'Создать Товар';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/products/' . $shop->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">
    <?= $this->render('_form', [
        'model' => $model,
        'product' => null,
        'shop' => $shop,
    ])?>
</div>

