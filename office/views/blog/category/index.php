<?php

use office\forms\blog\CategorySearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',

        ],
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Категория',
                'contentOptions' => ['data-label' => 'Категория'],
            ],
            [
                'attribute' =>'slug',
                'label' => 'Ссылка',
                'contentOptions' => ['data-label' => 'Ссылка'],
            ],
            [
                'attribute' =>'title',
                'label' => 'Заголовок',
                'contentOptions' => ['data-label' => 'Заголовок'],
            ],
            [
                'attribute' =>'description',
                'format' => 'ntext',
                'label' => 'Описание',
                'contentOptions' => ['data-label' => 'Описание'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
