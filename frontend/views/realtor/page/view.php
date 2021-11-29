<?php

use booking\entities\realtor\Page;
use booking\helpers\SysHelper;
use frontend\widgets\moving\MenuPagesWidget;
use frontend\widgets\reviews\NewReviewMovingWidget;
use frontend\widgets\reviews\CommentWidget;
use frontend\widgets\reviews\NewReviewWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page Page */
/* @var $categories Page[] */
/* @var $main_page bool */

$this->title = $page->getSeoTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);


$this->params['pages'] = true;
$this->params['slug'] = $page->slug;
$this->params['breadcrumbs'][] = ['label' => 'Земля', 'url' => Url::to(['/realtor'])];
if ($main_page) {
    $this->params['breadcrumbs'][] = ['label' => 'Информация'];
    $this->params['canonical'] = Url::to(['realtor/page/index'], true);
} else {

    $this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['/realtor/page/index'])];
    foreach ($page->parents as $parent) {
        if (!$parent->isRoot() && $parent->slug != 'info') {
            $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => Url::to(['realtor/page/view', 'slug' => $parent->slug])];
        }
    }
    $this->params['breadcrumbs'][] = $page->name;
    $this->params['canonical'] = Url::to(['realtor/page/view', 'slug' => $page->slug], true);
}


$mobile = SysHelper::isMobile();
?>

<h1 class="pb-4"><?= $page->title ?></h1>
<article class="page-view params-moving <?= $mobile ? 'word-break-table'  : ''?>">

    <?= SysHelper::lazyloaded($page->content); ?>

</article>
<?= MenuPagesWidget::widget(['pages' => $categories, 'section' => '/realtor/page']) ?>
