<?php

use booking\entities\blog\post\Comment;
use booking\entities\blog\post\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post Post */
/* @var $comment Comment */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">
    <p>
        <?= Html::a('Изменить', ['update', 'post_id' => $post->id, 'id' => $comment->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($comment->isActive()): ?>
            <?= Html::a('Удалить', ['delete', 'post_id' => $post->id, 'id' => $comment->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Удалить Комментарий?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
            <?= Html::a('Активировать', ['activate', 'post_id' => $post->id, 'id' => $comment->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Активировать Комментарий?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $comment,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата',
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'active',
                        'format' => 'boolean',
                        'label' => 'Статус'
                    ],
                    [
                            'attribute' => 'user_id',
                        'label' => 'Пользователь',
                        'value' => function (Comment $model) {
                            return $model->user->username;
                        }
                        ],
                    [
                        'attribute' => 'parent_id',
                        'label' => 'Родительский Комментарий',
                        'value' => function (Comment $model) {
                            if (empty($model->parent_id)) return '';
                            return StringHelper::truncate(strip_tags((Comment::findOne($model->parent_id))->text), 40);
                        },
                        ],
                    [
                        'attribute' => 'post_id',
                        'value' => $post->title,
                        'label' => 'Статья',
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($comment->text) ?>
        </div>
    </div>
</div>