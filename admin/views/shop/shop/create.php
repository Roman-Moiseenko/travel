<?php

use admin\assets\MapShopAsset;
use booking\forms\shops\ShopCreateForm;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */


$this->title = 'Создать Магазин';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $this->title;
MapShopAsset::register($this);
?>
<div class="tour-create">
    <?= $this->render('_form', [
        'model' => $model,
        'shop' => null,
    ])?>


</div>

