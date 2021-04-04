<?php

/* @var $this yii\web\View */
/* @var $post Post */

use booking\entities\blog\post\Post;
use booking\entities\Lang;
use frontend\assets\MagnificPopupAsset;
use frontend\widgets\blog\CommentsWidget;
use yii\helpers\Html;
use yii\helpers\Url;

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
MagnificPopupAsset::register($this);
?>
<article>
    <div itemscope="" itemtype="https://schema.org/Article">
        <span itemprop="name"><h1><?= Html::encode($post->getTitle()) ?></h1></span>
        <link itemprop="url" href="<?= Url::to(['/post/view', 'id' => $post->id], true)?>">
    <p><span class="glyphicon glyphicon-calendar"></span> <?= date('d-m-y H:i:s',$post->public_at); ?></p>

    <?php if ($post->photo): ?>
        <p><img itemprop="image" src="<?= Html::encode($post->getThumbFileUrl('photo', 'origin')) ?>" alt="<?= $post->getTitle()?>" class="img-responsive" /></p>
    <?php endif; ?>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', $post->public_at)?>">
        <meta itemprop="dateModified" content="<?= date('Y-m-d', $post->public_at)?>">
        <meta itemprop="headline" content="<?= $post->getTitle()?>">
        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <meta itemprop="name" content="ООО Кёнигс.РУ">
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-admin.jpg'; ?>">
            </div>
        </div>
        <div itemprop="mainEntityOfPage" itemscope itemtype="https://schema.org/URL">
        </div>
        <meta itemprop="author" content="ООО Кёнигс.РУ">
        <meta itemprop="description" content="<?= $post->getDescription() ?>">
        <div itemprop="articleBody">
            <?= Yii::$app->formatter->asHtml($post->getContent(), [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
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

