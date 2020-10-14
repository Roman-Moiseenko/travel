<?php

use booking\entities\blog\post\Post;
use booking\helpers\PostHelper;
use kartik\widgets\DatePicker;
use office\forms\blog\PostSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <p>
        <?= Html::a('Добавить Статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'category_id',
                'label' => 'Категории',
                'filter' => $searchModel->categoriesList(),
                'value' => 'category.name',
                'contentOptions' => ['data-label' => 'Категории'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_filter',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'todayHighLight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
                'contentOptions' => ['data-label' => 'Дата создания'],
            ],
            [
                'attribute' => 'title',
                'label' => 'Заголовок',
                'value' => function (Post $post) {
                    return Html::a(Html::encode($post->title), ['view', 'id' => $post->id]);
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Заголовок'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'filter' => PostHelper::statusList(),
                'value' => function (Post $model) {
                    return PostHelper::statusLabel($model->status);
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Статус'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
