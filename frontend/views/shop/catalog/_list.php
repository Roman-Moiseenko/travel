<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider ActiveDataProvider */
?>

<div class="row">
    <?php foreach ($dataProvider->getModels() as $product): ?>
        <?= $this->render('_product', [
            'product' => $product
        ]) ?>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-sm-6 text-left">
        <?=LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ])?>
    </div>
    <div class="col-sm-6 text-right">Показано <?= $dataProvider->getCount()?> из <?= $dataProvider->getTotalCount()?></div>
</div>

