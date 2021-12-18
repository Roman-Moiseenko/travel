<?php

use booking\entities\Lang;
use booking\entities\medicine\Page;
use booking\forms\CommentForm;
use booking\helpers\SysHelper;
use frontend\widgets\moving\MenuPagesWidget;
use frontend\widgets\reviews\NewReviewMedicineWidget;
use frontend\widgets\reviews\NewReviewMovingWidget;
use frontend\widgets\reviews\CommentWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page Page */
/* @var $categories Page[] */
/* @var $main_page bool */
/* @var $reviewForm CommentForm|null */

$this->title = Lang::t($page->getSeoTitle());

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);

$this->params['pages'] = true;
$this->params['slug'] = $page->slug;
if ($main_page) {
    $this->params['canonical'] = Url::to(['/medicine'], true);
    $this->params['breadcrumbs'][] = 'Медицинский туризм';
} else
{
    $this->params['canonical'] = Url::to(['medicine/medicine/view', 'slug' => $page->slug], true);

    $this->params['breadcrumbs'][] = ['label' => 'Медицинский туризм', 'url' => Url::to(['/medicine'])];
    $this->params['breadcrumbs'][] = $page->name;
}
/*
foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => Url::to(['medicine/medicine/view', 'slug' => $parent->slug])];
    }
}*/

$mobile = SysHelper::isMobile();
?>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<span id="data-page" data-id="<?= $page->id ?>"></span>

<h1 class="pb-4"><?= $page->title ?></h1>
<article class="page-view params-moving <?= $mobile ? 'word-break-table'  : ''?>">

    <?= SysHelper::lazyloaded($page->content); ?>


</article>
<?= MenuPagesWidget::widget(['pages' => $categories, 'section' => '/medicine/medicine']) ?>

<!-- Отзывы -->
<!-- Новый отзыв -->
<!-- ОТЗЫВЫ -->
<?php if ($reviewForm != null): ?>
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <h3>Комментарии:</h3>
        <div id="review" class="py-3">
            <?= CommentWidget::widget(['reviews' => $page->reviews]); ?>
        </div>
        <?= NewReviewMedicineWidget::widget(['page' => $page]); ?>
    </div>
</div>
<?php endif; ?>