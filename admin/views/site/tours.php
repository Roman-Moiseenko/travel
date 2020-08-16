<?php

use booking\entities\booking\tours\Tour;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\TourSearch */
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
                'value' => function (Tour $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'options' => ['width' => '40px'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Tour $model) {
                    return Html::a(Html::encode($model->name), ['/tours/common', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '35%'],
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => 'Описание'
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $url = Url::to(['/tours/tours-delete', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                        return Html::a($icon, $url, [
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'data-pjax' => 0,
                            'data-confirm' => 'Вы уверены, что хотите удалить Тур ' . $model->name . '?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
