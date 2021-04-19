<?php


use booking\entities\Lang;
use booking\entities\shops\products\Category;
use frontend\widgets\shop\CategoriesWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider ActiveDataProvider */
/* @var $category Category */
$this->title = Lang::t('Что привезти с Калининграда');
$this->params['breadcrumbs'][] = Lang::t('Каталог');
?>
<h1><?= Lang::t('Сувениры и подарки с Калининграда')?></h1>
<hr>
<div class="row">
    <aside id="column-left" class="col-md-3">
        <?= CategoriesWidget::widget([
            'active' => $this->params['active_category'] ?? null,
            // 'showcount' => true,
        ]); ?>
    </aside>
    <div class="col-md-9 col-sm-12">
        <?= ''//$this->render('_subcategories', ['category' =>$category,]);   ?>
        <?= $this->render('_list', [
            'dataProvider' => $dataProvider,
        ]); ?>
    </div>
</div>