<?php



/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\art\event\CategorySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'События (Искусство)';
$this->params['breadcrumbs'][] = 'Категории Событий';

use booking\entities\art\event\Category;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<p>
    <?= Html::a('Создать Категорию', Url::to(['create']), ['class' => 'btn btn-info']) ?>
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
                    'attribute' => 'icon',
                    'format' => 'raw',
                    'label' => 'Иконка',
                    'contentOptions' => ['data-label' => 'Иконка'],
                ],
                [
                    'attribute' => 'name',
                    'value' => function (Category $model) {
                        return Html::a($model->name, ['view', 'id' => $model->id]);
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
                    'label' => 'Сортировка',
                    'value' => function (Category $model) {
                        return
                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id],
                                ['data-method' => 'post',]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id],
                                ['data-method' => 'post',]);
                    },
                    'format' => 'raw',
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>