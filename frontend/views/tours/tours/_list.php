<?php


use booking\entities\Lang;
use booking\helpers\scr;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider DataProviderInterface */
$current = \Yii::$app->request->get('sort') ?? '';
$up = Lang::t('По возрастанию');
$down = Lang::t('По убыванию');
?>
<div class="sort-bar">
    <ul>
        <li <?php if ($current === '' ): ?>class="select"<?php endif; ?>>
            <a href="<?= Html::encode(Url::current(['sort' => ''])) ?>"><?= Lang::t('по умолчанию') ?></a>
        </li>
        <li <?php if ($current === 'name'): ?>class="select"<?php endif; ?>>
            <a href="<?= Html::encode(Url::current(['sort' => 'name'])) ?>"><?= Lang::t('по имени (А-Я)') ?></a>
        </li>
        <li <?php if ($current === '-rating'): ?>class="select"<?php endif; ?>>
            <a href="<?= Html::encode(Url::current(['sort' => '-rating'])) ?>"><?= Lang::t('по рейтингу (сначала высокий)') ?></a>
        </li>
        <li <?php if ($current === 'cost'): ?>class="select"<?php endif; ?>>
            <a href="<?= Html::encode(Url::current(['sort' => 'cost'])) ?>"><?= Lang::t('по цене (сначала дешевле)') ?></i></a>
        </li>
    </ul>
</div>

<div class="row row-cols-1 row-cols-md-4">
    <?php foreach ($dataProvider->getModels() as $tour): ?>
        <?= $this->render('_tour', [
            'tour' => $tour
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
