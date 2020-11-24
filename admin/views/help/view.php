<?php

use booking\entities\admin\Help;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page Help */

$this->title = $page->getSeoTitle();
$this->params['page_id'] = $page->id;
foreach ($page->parents as $parent) {
    //if (!$parent->isRoot())
    $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['view', 'id' => $parent->id]];
}
$this->params['breadcrumbs'][] = $page->title;
?>
<article class="page-view">
    <?= Yii::$app->formatter->asHtml($page->content, [
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeObject' => true,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?>

</article>
