<?php

/* @var $this yii\web\View */

/* @var $model Post */

use booking\entities\blog\post\Post;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['post', 'id' => $model->id]);
?>

<div class="blog-posts-item">
    <?php if ($model->photo): ?>
        <div>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($model->getThumbFileUrl('photo', 'blog_list')) ?>" alt="<?= $model->getTitle() ?>"
                     class="img-responsive"/>
            </a>
        </div>
    <?php endif; ?>
    <h2><a href="<?= Html::encode($url) ?>"><?= Html::encode($model->getTitle()) ?></a></h2>
    <p><?= Yii::$app->formatter->asNtext($model->getDescription()) ?></p>
</div>


