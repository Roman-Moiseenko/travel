<?php

use booking\entities\Lang;
use booking\entities\shops\products\Category;
use frontend\widgets\shop\CategoriesWidget;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $category Category*/
/* @var $dataProvider DataProviderInterface */

$this->title = Lang::t($category->getSeoTile());
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => Lang::t('Каталог'), 'url' => '/shops'];
foreach ($category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => Url::to(['category', 'id' => $parent->id])];
    }
}
$this->params['breadcrumbs'][] = $category->name;
$this->params['active_category'] = $category;
$this->params['canonical'] = Url::to(['/shop/catalog/'. $category->id], true);

$this->params['id_category'] = $category->id;
?>

    <h1><?=Html::encode(Lang::t($category->getHeadingTile()))?></h1>
    <hr/>

<?php if ($category->description):?>
    <div class="card">
        <div class="card-body">
            <?=Yii::$app->formatter->asNtext($category->description);?>
        </div>
    </div>
<?php endif;?>
<div class="row">
    <aside id="column-left" class="col-md-3">
        <?= CategoriesWidget::widget([
            'active' => $this->params['active_category'] ?? null,
             //'showcount' => true,
        ]); ?>
    </aside>
    <div class="col-md-9 col-sm-12">
        <?= ''//$this->render('_subcategories', ['category' =>$category,]);   ?>
        <?= $this->render('_list', [
            'dataProvider' => $dataProvider,
        ]); ?>
    </div>
</div>