<?php

use booking\entities\booking\tours\stack\Stack;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use booking\helpers\tours\TourHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\TourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Стек туров';
$this->params['breadcrumbs'][] = ['label' => 'Мои Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать стек', Url::to('/tour/stack/create'), ['class' => 'btn btn-success']) ?>
    </p>
    <p>Стек туров предназначен если у Вас количество экскурсий превыщает количества гидов. <br>При заполнении стека, в любой из дней,
        разные группы клиентов могут заказать любую экскурсию из стека, но не более чем количество гидов. Что предотвратит овербукинг.</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'label' => '#ID',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'ID'],
            ],
            [
                'attribute' => 'legal_id',
                'label' => 'Организация',
                'value' => function (Stack $model) {
                    return $model->legal->caption;
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Организация'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Stack $model) {
                    return Html::a(Html::encode($model->name), ['/tour/stack/view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'label' => 'Кол-во',
                'attribute' => 'count',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'Кол-во'],
            ],
            ['class' => 'yii\grid\ActionColumn',

            ],
        ],
    ]); ?>

</div>
