<?php

use booking\entities\shops\AdShop;

use booking\forms\shops\AdProductForm;


/* @var $this yii\web\View */
/* @var $model AdProductForm */
/* @var $shop AdShop */

$this->title = 'Создать Товар';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop-ad/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop-ad/products/' . $shop->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">
    <?= $this->render('_form', [
        'model' => $model,
        'product' => null,
    ])?>
</div>

