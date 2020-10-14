<?php

use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use booking\helpers\ToursHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\TourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои туры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Тур', Url::to('tour/common/create'), ['class' => 'btn btn-success']) ?>
    </p>


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
                'value' => function (Tour $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
                'options' => ['width' => '100px'],
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function (Tour $model) {
                    return StatusHelper::statusToHTML($model->status);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => StatusHelper::listStatus(),
                'contentOptions' => ['data-label' => 'Статус'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Tour $model) {
                    return Html::a(Html::encode($model->name), ['/tour/common', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'description',
                'value' => function (Tour $model) {
                    return StringHelper::truncateWords(strip_tags($model->description), 40);

                },
                'format' => 'ntext',
                'label' => 'Описание',
                'contentOptions' => ['data-label' => 'Описание'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $url = Url::to(['/tour/delete', 'id' => $model->id]);
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
