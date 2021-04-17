<?php


use booking\entities\shops\products\Category;
use frontend\widgets\shop\CategoriesWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $dataProvider ActiveDataProvider */
/* @var $category Category */
$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($category->getHeadingTile()) ?></h1>
<hr>
<div class="row">
    <aside id="column-left" class="col-sm-3 hidden-xs">
        <?= CategoriesWidget::widget([
            'active' => $this->params['active_category'] ?? null,
            // 'showcount' => true,
        ]); ?>
    </aside>
    <div class="col-sm-9">
        <?= ''//$this->render('_subcategories', ['category' =>$category,]);   ?>

        <?= $this->render('_list', [
            'dataProvider' => $dataProvider,
        ]); ?>
    </div>
</div>