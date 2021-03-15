<?php

use booking\entities\blog\post\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $posts Post[] */
/* @var $mobile boolean */
$count = count($posts);
?>
<?php if ($count != 0): ?>
<div class="row">
    <div class="col p-1">
        <div class="card text-white shadow-lg" style="border: 0 !important; ">
            <img data-src="<?= $posts[0]->getThumbFileUrl('photo', $mobile ? 'widget_mobile' : 'widget_top') ?>"
                 class="card-img lazyload"
                 alt="<?= $posts[0]->getTitle() ?>"
                 title="<?= $posts[0]->getTitle() ?>">
            <div class="card-img-overlay">
                <h3 class="card-title title-blog-wodget"><?= $posts[0]->getTitle() ?></h3>
                <div class=" d-none d-sm-block">
                <p class="card-text"><?= Html::encode(StringHelper::truncateWords(strip_tags($posts[0]->getDescription()), 60)) ?></p>
                </div>
            </div>
            <a href="<?= Url::to(['post/view', 'id' => $posts[0]->id]) ?>" class="stretched-link"></a>
        </div>
    </div>
</div>
<div class="row">
    <?php for ($i = 1; $i < $count; $i++): ?>
        <div class="col-sm-4 px-1">
            <div class="card text-white shadow-lg" style="border: 0 !important; ">
                <img data-src="<?= $posts[$i]->getThumbFileUrl('photo', $mobile ? 'widget_mobile' : 'widget_bottom') ?>"
                     class="card-img lazyload"
                     alt="<?= $posts[$i]->getTitle() ?>"
                     title="<?= $posts[$i]->getTitle() ?>">
                <div class="card-img-overlay">
                    <h3 class="card-title title-blog-wodget"><?= $posts[$i]->getTitle() ?></h3>
                    <div class=" d-none d-sm-block">
                    <p class="card-text"><?= Html::encode(StringHelper::truncateWords(strip_tags($posts[$i]->getDescription()), 20)) ?></p>
                    </div>
                </div>
                <a href="<?= Url::to(['post/view', 'id' => $posts[$i]->id]) ?>" class="stretched-link"></a>
            </div>
        </div>
    <?php endfor; ?>
</div>
<?php endif; ?>