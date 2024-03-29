<?php

use booking\entities\Lang;
use booking\helpers\SchemaHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page \booking\entities\Page */

$this->title = Lang::t($page->getSeoTitle());

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);

foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => Url::to(['view', 'id' => $parent->id])];
    }
}
$this->params['canonical'] = Url::to(['/' . $page->slug], true);

$this->params['breadcrumbs'][] = $page->title;
?>
<article class="page-view">

    <h1><?= Lang::t(Html::encode($page->title)) ?></h1>

    <?= $page->content; /*Yii::$app->formatter->asHtml($page->content, [
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeObject' => false,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) */?>

</article>
