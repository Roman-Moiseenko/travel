<?php

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use yii\data\DataProviderInterface;
use yii\widgets\LinkPager;

?>

<div class="row row-cols-1 row-cols-md-4">
    <?php //TODO Показать из списка рекомендуемых, не более 4 (Виджет). Проплаченные Провайдерами ?>
    <?php foreach ($dataProvider->getModels() as $food): ?>
        <?= $this->render('_food', [
            'food' => $food
        ]) ?>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= Lang::t('Показано') . ' ' . $dataProvider->getCount() . ' ' . Lang::t('из') . ' ' . $dataProvider->getTotalCount() ?></div>
</div>