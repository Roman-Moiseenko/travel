<?php

use booking\entities\touristic\fun\Category;
use booking\entities\touristic\fun\Fun;
use office\forms\touristic\FunSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $category Category */
/* @var $searchModel FunSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Редактировать', Url::to(['update-category', 'id' => $category->id]), ['class' => 'btn btn-warning'])?>
    <?= Html::a('Добавить Развлечение', Url::to(['create-fun', 'id' => $category->id]), ['class' => 'btn btn-success'])?>
</p>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <a href="<?= $category->getUploadedFileUrl('photo')?>">
                    <img src="<?= $category->getThumbFileUrl('photo', 'admin')?>" class="img-responsive">
                </a>
            </div>
            <div class="col-sm-8">
                <?= $category->description ?>
            </div>
        </div>
    </div>
</div>

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
                    'attribute' => 'main_photo_id',
                    'value' => function (Fun $model) {
                        return $model->main_photo_id ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin'), ['class' => 'img-responsive']) : '';
                    },
                    'format' => 'raw',
                    'label' => 'Фото',
                    'contentOptions' => ['data-label' => 'Фото'],
                ],
                [
                    'attribute' => 'name',
                    'value' => function (Fun $model) {
                        return Html::a($model->name, ['view-fun', 'id' => $model->id]);
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
                    'value' => function (Fun $model) {
                        return
                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-fun', 'category_id' => $model->category_id, 'id' => $model->id],
                                ['data-method' => 'post',]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-fun', 'category_id' => $model->category_id, 'id' => $model->id],
                                ['data-method' => 'post',]);
                    },
                    'format' => 'raw',
                ],
                [
                    'value' => function (Fun $model) {
                        return 'TODO добавить'; //count($model->funs) . ' объектов';
                    },
                    'label' => 'Featured',
                    'contentOptions' => ['data-label' => 'Featured'],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
