<?php

use booking\entities\Lang;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider ActiveDataProvider */
$current = \Yii::$app->request->get('sort') ?? '';
$up = Lang::t('По возрастанию');
$down = Lang::t('По убыванию');
$values = [
    '' => Lang::t('по умолчанию'),
    'name' => Lang::t('по имени (А-Я)'),
    '-rating' => Lang::t('по рейтингу (сначала высокий)'),
    'cost' => Lang::t('по цене (сначала дешевле)'),

];
?>

<div class="sort-bar d-none d-sm-block">
    <ul>
        <?php foreach ($values as $value => $label): ?>
            <li <?php if ($current === $value ): ?>class="select"<?php endif; ?>>
                <a href="<?= Html::encode(Url::current(['sort' => $value])) ?>" rel="nofollow"><?= $label ?></a>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<div class="sort-bar d-sm-none">
    <select id="input-sort" class="form-control" onchange="location = this.value;">
        <?php foreach ($values as $value => $label): ?>
            <option value="<?=Html::encode(Url::current(['sort' => $value ?: null]))?>"
                    <?php if ($value === $current):?>selected="selected"<?php endif; ?>><?=$label?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="row pt-2">
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

