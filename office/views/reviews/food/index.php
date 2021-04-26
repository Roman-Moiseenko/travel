<?php

use booking\entities\foods\ReviewFood;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\reviews\ReviewFoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы на Заведения';
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
                        'attribute' => 'food_id',
                        'value' => function (ReviewFood $model) {
                            return Html::a($model->food->name, ['/info/foods/food/view', 'id' => $model->food_id]);
                        },
                        'label' => 'Тур',
                        'format' => 'raw',
                        'options' => ['width' => '20%'],
                        'contentOptions' => ['data-label' => 'Тур'],
                    ],
                    [
                        'attribute' => 'username',
                        'value' => function (ReviewFood $model) {
                            return $model->username;
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
                   /* ['class' => ActionColumn::class,
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, ReviewFood $model, $key) {
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
                    ],*/
                ],
            ]); ?>
        </div>
    </div>
</div>