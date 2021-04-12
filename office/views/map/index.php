<?php

use booking\entities\blog\map\Maps;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <p>
        <?= Html::a('Создать Карту', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'value' => function (Maps $model) {

                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Заголовок'],
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                    'contentOptions' => ['data-label' => 'Ссылка'],
                ],
                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>