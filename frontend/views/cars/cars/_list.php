<?php


use booking\entities\Lang;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider DataProviderInterface */
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
            <a href="<?= Html::encode(Url::current(['sort' => $value])) ?>"><?= $label ?></a>
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
<div class="row">
<div class="col-sm-12">
    <?php //TODO Показать из списка рекомендуемых, не более 4 (Виджет). Проплаченные Провайдерами ?>
    <?php
    foreach ($dataProvider->getModels() as $car): ?>
        <?= $this->render( SysHelper::isMobile() ? '_car_mobile' : '_car', [
            'car' => $car
        ]) ?>
    <?php endforeach; ?>
</div>
</div>
<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= Lang::t('Показано') . ' ' . $dataProvider->getCount() . ' ' . Lang::t('из') . ' ' . $dataProvider->getTotalCount() ?></div>
</div>
