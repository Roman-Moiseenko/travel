<?php

use booking\entities\touristic\fun\Category;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\info\NewProviderWidget;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;


/* @var $this \yii\web\View */
/* @var $dataProvider DataProviderInterface */
/* @var $category Category */
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $category->meta->description]);
$this->title = $category->meta->title;

$this->params['breadcrumbs'][] = ['label' => 'Отдых и Развлечения', 'url' => Url::to(['funs/index'])];
$this->params['breadcrumbs'][] = $category->name;

$this->params['canonical'] = Url::to(['funs/category', 'id' => $category->id], true);

$this->params['fun'] = true;
MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$this->params['emoji'] = Emoji::FUN;
$current = \Yii::$app->request->get('sort') ?? '';
$up = 'По возрастанию';
$down = 'По убыванию';
$values = [
    '-id' => 'по умолчанию',
    'name' => 'по имени (А-Я)',
    '-rating' => 'по рейтингу (сначала высокий)',

];
?>

<h1><?= $category->title ?></h1>


    <!--div class="sort-bar d-none d-sm-block">
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
    </div-->
    <div class="row <?= $mobile ? 'row-cols-1 row-cols-md-4' : ''?>">
        <div class="<?= $mobile ? '' : 'col-sm-12'?>">
            <?php //TODO Показать из списка рекомендуемых, не более 4 (Виджет). Проплаченные Провайдерами ?>
            <?php foreach ($dataProvider->getModels() as $fun): ?>
                <?= $this->render($mobile ? '_fun_mobile' : '_fun', [
                    'fun' => $fun
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
        <div class="col-sm-6 text-right"><?= 'Показано ' . $dataProvider->getCount() . ' из ' . $dataProvider->getTotalCount() ?></div>
    </div>

    <p class="pt-4" style="font-size: 22px">База развлечений и мест отдыха наполняется ... </p>
    <p  style="font-size: 18px">Подождите немного, через несколько дней мы постараемся ее наполнить</p>

<?= NewProviderWidget::widget()?>