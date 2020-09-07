<?php


use booking\entities\Lang;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider DataProviderInterface */

?>

<div class="row">
    <div class="col-md-6 hidden-sm">
    </div>
    <div class="col-md-4 col-sm-7">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text"><?= Lang::t('Сортировать') ?>:</span>
            </div>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
                <?php
                $values = [
                    '' => Lang::t('по умолчанию'),
                    'name' => Lang::t('по имени (А-Я)'),
                    '-name' => Lang::t('по имени (Я-А)'),
                    'rating' => Lang::t('по рейтингу (высокий рейтинг)'),
                    '-rating' => Lang::t('по рейтингу (низкий рейтинг)'),
                ];
                $current = Yii::$app->request->get('sort');
                ?>
                <?php foreach ($values as $value => $label): ?>
                    <option value="<?= Html::encode(Url::current(['sort' => $value ?: null])) ?>"
                            <?php if ($value === $current): ?>selected="selected"<?php endif; ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-2 col-sm-5">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text"><?= Lang::t('Показать') ?>:</span>
            </div>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
                <?php
                $values = [15, 25, 50, 75, 100];
                $current = $dataProvider->getPagination()->getPageSize();
                ?>
                <?php foreach ($values as $value): ?>
                    <option value="<?= Html::encode(Url::current(['per-page' => $value ?: null])) ?>"
                            <?php if ($value === $current): ?>selected="selected"<?php endif; ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="row row-cols-1 row-cols-md-4 m-1 p-1" >
    <?php foreach ($dataProvider->getModels() as $tour): ?>
        <?= $this->render('_tour', [
            'tour' => $tour
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
