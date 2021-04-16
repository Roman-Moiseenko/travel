<?php

use admin\assets\MapShopAsset;
use booking\entities\shops\AdShop;
use booking\forms\shops\ShopAdCreateForm;

/* @var $this yii\web\View */
/* @var $model ShopAdCreateForm */
/* @var $shop AdShop */

$this->title = 'Редактировать ' . $shop->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop-ad/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
MapShopAsset::register($this);
?>
<div class="shop-ad-update">
    <?= $this->render('_form', [
        'model' => $model,
        'shop' => $shop,
    ]) ?>

</div>

