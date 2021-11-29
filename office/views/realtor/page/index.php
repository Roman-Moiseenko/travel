<?php

use booking\entities\realtor\Page;
use booking\helpers\StatusHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\realtor\PageSearch */
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
                    'attribute' => 'name',
                    'value' => function (Page $model) {
                        $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                        return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Название'],
                ],
                [
                    'attribute' => 'title',
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
                [
                    'attribute' => 'status',
                    'label' => 'Статус',
                    'filter' => [StatusHelper::STATUS_DRAFT => 'Черновик', StatusHelper::STATUS_ACTIVE => 'Опубликована'],
                    'value' => function (Page $model) {
                        return StatusHelper::statusToHTML($model->status);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['data-label' => 'Статус'],
                ],
                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>