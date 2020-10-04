<?php

use booking\entities\blog\post\Post;
use booking\forms\blog\post\PostForm;
/* @var $this yii\web\View */
/* @var $post Post */
/* @var $model PostForm */

$this->title = 'Редактировать Статью: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Изменить';


?>
<div class="post-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
