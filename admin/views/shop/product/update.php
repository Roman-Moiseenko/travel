<?php

use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\forms\shops\ProductForm;

/* @var $this yii\web\View */
/* @var $model ProductForm */
/* @var $shop Shop */
/* @var $product Product */

$this->title = 'Редактировать ' . $product->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/products/' . $shop->id]];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['/shop/product/view', 'id' => $product->id]];

$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product' => $product,
        'shop' => $shop,

    ]) ?>

</div>

