<?php

/* @var $this yii\web\View */
/* @var $post Post */

use booking\entities\blog\post\Post;
use booking\entities\Lang;
use frontend\widgets\blog\CommentsWidget;
use yii\helpers\Html;

$this->title = $post->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $post->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => Lang::t('Блог'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->category->getName(), 'url' => ['category', 'slug' => $post->category->slug]];
$this->params['breadcrumbs'][] = $post->getTitle();

$this->params['active_category'] = $post->category;

$tagLinks = [];
foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug]);
}
?>

<article>
    <h1><?= Html::encode($post->getTitle()) ?></h1>

    <p><span class="glyphicon glyphicon-calendar"></span> <?= date('d-m-y H:i:s',$post->public_at); ?></p>

    <?php if ($post->photo): ?>
        <p><img src="<?= Html::encode($post->getThumbFileUrl('photo', 'origin')) ?>" alt="" class="img-responsive" /></p>
    <?php endif; ?>

    <?= Yii::$app->formatter->asHtml($post->getContent(), [
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeObject' => true,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?>
</article>

<p><?= Lang::t('Метки') ?>: <?= implode(', ', $tagLinks) ?></p>
<div class="addthis_inline_share_toolbox"></div>
<?= CommentsWidget::widget([
    'post' => $post,
]) ?>


