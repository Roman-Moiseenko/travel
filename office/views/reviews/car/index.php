<?php

use booking\entities\booking\cars\ReviewCar;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\reviews\ReviewCarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы на Авто';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="reviews-list">
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
                        'attribute' => 'car_id',
                        'value' => function (ReviewCar $model) {
                            return Html::a($model->car->name, ['/cars/view', 'id' => $model->car_id]);
                        },
                        'label' => 'Тур',
                        'format' => 'raw',
                        'options' => ['width' => '20%'],
                        'contentOptions' => ['data-label' => 'Тур'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => function (ReviewCar $model) {
                            return $model->user->username;
                        },
                        'label' => 'Клиент',
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Клиент'],
                    ],
                    [
                        'attribute' => 'vote',
                        'label' => 'Рейтинг',
                        'contentOptions' => ['data-label' => 'Рейтинг'],
                    ],
                    [
                        'attribute' => 'text',
                        'label' => 'Отзыв',
                        'format' => 'ntext',
                        'contentOptions' => ['data-label' => 'Отзыв'],
                    ],
                    ['class' => ActionColumn::class,
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, ReviewCar $model, $key) {
                                if ($model->isActive()) {
                                    $url = Url::to(['lock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-unlock", 'style' => 'color: #28a745']);
                                    return Html::a($icon, $url, [
                                        'title' => 'Заблокировать',
                                        'aria-label' => 'Заблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите заблокировать Отзыв?',
                                        'data-method' => 'post',
                                    ]);
                                } else {
                                    $url = Url::to(['unlock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-lock", 'style' => 'color: #dc3545']);
                                    return Html::a($icon, $url, [
                                        'title' => 'Разблокировать',
                                        'aria-label' => 'Разблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите разблокировать Отзыв?',
                                        'data-method' => 'post',
                                    ]);
                                }
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>