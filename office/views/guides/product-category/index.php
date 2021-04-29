<?php

use booking\entities\shops\products\Category;
use office\forms\guides\ProductCategorySearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel  ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="category-index">

    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function (Category $model) {
                    return '<img src="' . $model->getThumbFileUrl('photo', 'admin') . '">';
                },
                'format' => 'raw',
                'label' => 'IMG'
            ],
            [
                'attribute' => 'name',
                'value' => function (Category $model) {
                    $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                    return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Категория'
            ],
            [
                'value' => function (Category $model) {
                    return
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id],
                            ['data-method' => 'post',]);
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            [
                'attribute' => 'slug',
                'label' => 'Ссылка'
            ],
            [
                'attribute' => 'title',
                'label' => 'Заголовок'
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => 'Описание'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>