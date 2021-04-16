<?php

use admin\assets\MapShopAsset;
use booking\entities\shops\AdShop;
use booking\forms\shops\ShopAdCreateForm;

/* @var $this yii\web\View */
/* @var $model ShopAdCreateForm */
/* @var $shop AdShop */

$this->title = 'Создать Магазин (Реклама)';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $this->title;

MapShopAsset::register($this);
?>
<div class="shop-ad-create">
    <?= $this->render('_form', [
        'model' => $model,
        'shop' => $shop,
    ])?>


</div>

