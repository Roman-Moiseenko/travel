<?php

use booking\entities\shops\AdShop;
use booking\entities\shops\products\AdProduct;
use booking\forms\shops\AdProductForm;

/* @var $this yii\web\View */
/* @var $model AdProductForm */
/* @var $shop AdShop */
/* @var $product AdProduct */

$this->title = 'Редактировать ' . $product->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop-ad/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop-ad/products/' . $shop->id]];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['/shop-ad/product/view', 'id' => $product->id]];

$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product' => $product,
    ]) ?>

</div>

