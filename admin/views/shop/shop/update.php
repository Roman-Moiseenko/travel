<?php

use admin\assets\MapShopAsset;
use booking\entities\shops\Shop;
use booking\forms\shops\ShopCreateForm;


/* @var $this yii\web\View */
/* @var $model ShopCreateForm */
/* @var $shop Shop */

$this->title = 'Редактировать ' . $shop->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

MapShopAsset::register($this);
?>
<div class="tour-update">

    <?= $this->render('_form', [
        'model' => $model,
        'shop' => $shop,
    ]) ?>

</div>

