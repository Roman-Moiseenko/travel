<?php

use booking\entities\blog\post\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $posts Post[] */

$count = count($posts);
?>
<div class="row">
    <div class="col p-1">
        <div class="card text-white shadow-lg" style="border: 0 !important; ">
            <img src="<?= $posts[0]->getThumbFileUrl('photo', 'widget_top') ?>" class="card-img">
            <div class="card-img-overlay">
                <h4 class="card-title" style="color: white; text-shadow: black 2px 2px 1px"><?= $posts[0]->title ?></h4>
                <p class="card-text"><?= Html::encode(StringHelper::truncateWords(strip_tags($posts[0]->description), 60)) ?></p>
            </div>
            <a href="<?= Url::to(['post/view', 'id' => $posts[0]->id]) ?>" class="stretched-link"></a>
        </div>
    </div>
</div>
<div class="row">
    <?php for ($i = 1; $i < $count; $i++): ?>
        <div class="col-sm-4 px-1">

            <div class="card text-white shadow-lg" style="border: 0 !important; ">
                <img src="<?= $posts[$i]->getThumbFileUrl('photo', 'widget_bottom') ?>" class="card-img">
                <div class="card-img-overlay">
                    <h4 class="card-title"
                        style="color: white; text-shadow: black 2px 2px 1px"><?= $posts[$i]->title ?></h4>
                    <p class="card-text"><?= Html::encode(StringHelper::truncateWords(strip_tags($posts[$i]->description), 20)) ?></p>
                </div>
                <a href="<?= Url::to(['post/view', 'id' => $posts[$i]->id]) ?>" class="stretched-link"></a>
            </div>
        </div>
    <?php endfor; ?>
</div>
