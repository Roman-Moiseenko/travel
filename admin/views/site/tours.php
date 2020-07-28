<?php

use booking\entities\booking\tours\Tours;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ToursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои туры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Тур', Url::to('tours/common/create'), ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function (Tours $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Tours $model) {
                    return Html::a(Html::encode($model->name), ['/tours/common', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название'
            ],
            [
                'attribute' =>'description',
                'format' => 'ntext',
                'label' => 'Описание'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
