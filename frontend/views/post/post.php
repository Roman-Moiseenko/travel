<?php

/* @var $this yii\web\View */
/* @var $post Post */

use booking\entities\blog\post\Post;
use booking\entities\Lang;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapBlogAsset;
use frontend\widgets\blog\CommentsWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->title = Lang::t($post->getSeoTitle());

$this->registerMetaTag(['name' =>'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $post->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => Lang::t('Блог'), 'url' => Url::to(['/post'])];
$this->params['breadcrumbs'][] = ['label' => $post->category->getName(), 'url' => Url::to(['/post/category', 'slug' => $post->category->slug])];
$this->params['breadcrumbs'][] = $post->getTitle();

$this->params['active_category'] = $post->category;

$tagLinks = [];
foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug]);
}
JqueryAsset::register($this);

MagnificPopupAsset::register($this);
MapBlogAsset::register($this);
?>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<article>
    <div itemscope="" itemtype="https://schema.org/Article">
        <span itemprop="name"><h1><?= Html::encode($post->getTitle()) ?></h1></span>
        <link itemprop="url" href="<?= Url::to(['/post/view', 'id' => $post->id], true)?>">
    <p><i class="far fa-calendar-alt"></i> <?= date('d-m-y H:i:s',$post->public_at); ?></p>

    <?php if ($post->photo): ?>
        <div class="item-responsive item-post">
            <div class="content-item">
                <img src="<?= Html::encode($post->getThumbFileUrl('photo', 'origin')) ?>"
                 alt="<?= $post->getTitle()?>" class="img-responsive" itemprop="image" loading="lazy" />
            </div>
        </div>
    <?php endif; ?>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', $post->public_at)?>">
        <meta itemprop="dateModified" content="<?= date('Y-m-d', $post->public_at)?>">
        <meta itemprop="headline" content="<?= $post->getTitle()?>">
        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <meta itemprop="name" content="ООО Кёнигс.РУ">
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <link itemprop="contentUrl" href="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-admin.jpg'; ?>">
            </div>
        </div>
        <div itemprop="mainEntityOfPage" itemscope itemtype="https://schema.org/URL">
        </div>
        <meta itemprop="author" content="ООО Кёнигс.РУ">
        <meta itemprop="description" content="<?= $post->getDescription() ?>">
        <div itemprop="articleBody">
            <?= SysHelper::lazyloaded(Yii::$app->formatter->asRaw($post->getContent())) ?>
        </div>
    </div>
</article>
<p><?= Lang::t('Метки') ?>: <?= implode(', ', $tagLinks) ?></p>
<?= CommentsWidget::widget([
    'post' => $post,
]) ?>
<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>

