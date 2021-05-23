<?php

use booking\entities\Lang;
use booking\entities\moving\Page;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page Page */
/* @var $categories Page[] */


$this->title = Lang::t($page->getSeoTitle());

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);

$this->params['canonical'] = Url::to(['moving/moving/view', 'slug' => $page->slug], true);
$this->params['pages'] = true;

$this->params['breadcrumbs'][] = ['label' => 'Переезд на ПМЖ', 'url' => Url::to(['/moving'])];
foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => Url::to(['moving/moving/view', 'slug' => $parent->slug])];
    }
}
$this->params['breadcrumbs'][] = $page->title;
?>

<div class="pb-3">
<?php foreach ($categories as $category): ?>
    <a class="moving-menu-page" href="<?= Url::to(['moving/moving/view', 'slug' => $category->slug])?>"> <?= $category->title ?></a>
<?php endforeach; ?>
</div>
<article class="page-view">
    <h1><?= Lang::t(Html::encode($page->title)) ?></h1>
    <?= Yii::$app->formatter->asHtml($page->content, [
        'Attr.AllowedRel' => array('nofollow'),
        //'HTML.SafeObject' => true,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?>
</article>



