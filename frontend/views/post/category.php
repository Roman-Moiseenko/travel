<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category Category */

use booking\entities\blog\Category;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use frontend\widgets\templates\TagsWidget;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $category->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $category->meta->keywords]);

$this->params['canonical'] = Url::to(['/post/category', 'slug' => $category->slug], true);
$this->params['breadcrumbs'][] = ['label' => Lang::t('Блог'), 'url' => Url::to(['/post'])];
$this->params['breadcrumbs'][] = $category->getName();

$this->params['active_category'] = $category;
?>

<h1><?= Html::encode($category->getHeadingTile()) ?></h1>

<?php if (trim($category->getDescription())): ?>
    <div class="card card-default">
        <div class="card-body text-justify">
            <?= Yii::$app->formatter->asHtml($category->getDescription(), [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
<!--Облако тегов-->
<?= TagsWidget::widget([
    'object' => Tour::class
]) ?>

