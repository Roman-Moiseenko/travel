<?php

use booking\entities\blog\post\Post;
use booking\forms\blog\post\CommentEditForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post Post */
/* @var $model CommentEditForm */

$this->title = 'Изменить: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="post-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="card card-default">
        <div class="card-header with-border"></div>
        <div class="card-body">
            <?= $form->field($model, 'parentId')->textInput()->label('Родительский комментарий') ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 20])->label('Текст') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
