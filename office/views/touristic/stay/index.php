<?php

use booking\entities\touristic\stay\Category;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\touristic\StayCategorySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Проживания';
$this->params['breadcrumbs'][] = 'Категории';

?>

<p>
    <?= Html::a('Создать Категорию', Url::to(['create-category']), ['class' => 'btn btn-info']) ?>
</p>
<div class="card">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-adaptive table-striped table-bordered',
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['width' => '20px',],
                    'contentOptions' => ['data-label' => 'ID'],
                ],
                [
                    'attribute' => 'photo',
                    'value' => function (Category $model) {
                        return Html::img($model->getThumbFileUrl('photo', 'admin'), ['class' => 'img-responsive']);
                    },
                    'format' => 'raw',
                    'label' => 'Фото',
                    'contentOptions' => ['data-label' => 'Фото'],
                ],
                [
                    'attribute' => 'name',
                    'value' => function (Category $model) {
                        return Html::a($model->name, ['view-category', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Название'],
                ],

                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                    'contentOptions' => ['data-label' => 'Ссылка'],
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Описание',
                    'contentOptions' => ['data-label' => 'Описание'],
                ],
                [
                    'label' => 'Сортировка',
                    'value' => function (Category $model) {
                        return
                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-category', 'id' => $model->id],
                                ['data-method' => 'post',]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-category', 'id' => $model->id],
                                ['data-method' => 'post',]);
                    },
                    'format' => 'raw',
                ],
                [
                    'value' => function (Category $model) {
                         return 'TODO';//count($model->stays);
                    },
                    'label' => 'Кол-во',
                    'contentOptions' => ['data-label' => 'Кол-во'],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>