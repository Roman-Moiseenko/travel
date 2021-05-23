<?php

use booking\entities\moving\Page;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\moving\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <p>
        <?= Html::a('Создать Страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-adaptive table-striped table-bordered',
            ],
            'columns' => [
                [
                    'attribute' => 'title',
                    'value' => function (Page $model) {
                        $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                        return $indent . Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Заголовок',
                    'contentOptions' => ['data-label' => 'Заголовок'],
                ],
                [
                    'value' => function (Page $model) {
                        return
                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Сортировка',
                    'options' => ['style' => 'text-align: center'],
                    'contentOptions' => ['data-label' => 'Сортировка'],
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                    'contentOptions' => ['data-label' => 'Ссылка'],
                ],
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок',
                    'contentOptions' => ['data-label' => 'Заголовок'],
                    ],
                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>