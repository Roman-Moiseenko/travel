<?php

use booking\entities\blog\post\Comment;
use office\forms\blog\CommentSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <div class="card">
        <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                    'attribute' => 'id',
                'options' => ['width' => '20px'],
                ],
            [
                    'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => 'datetime',
                ],
            [
                'attribute' => 'text',
                'value' => function (Comment $model) {
                    return StringHelper::truncate(strip_tags($model->text), 100);
                },
                'label' => 'Текст',
            ],
            [
                'attribute' => 'active',
                'filter' => $searchModel->activeList(),
                'format' => 'boolean',
                'label' => 'Статус'
            ],
            ['class' => ActionColumn::class],
        ],
    ]); ?>

        </div>
    </div>
</div>
