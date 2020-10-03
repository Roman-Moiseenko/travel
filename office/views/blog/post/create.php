<?php

use booking\entities\blog\post\Post;

/* @var $this yii\web\View */
/* @var $model Post */

$this->title = 'Добавить Статью';
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
