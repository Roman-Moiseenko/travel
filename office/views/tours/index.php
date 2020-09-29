<?php

use booking\entities\booking\tours\Tour;
use booking\helpers\AdminUserHelper;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\ToursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Туры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-list">
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'options' => ['width' => '20px',]
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Tour $model) {
                            return Html::a($model->name, ['tours/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Название'
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StatusHelper::listStatus(),
                        'value' => function (Tour $model) {
                            return StatusHelper::statusToHTML($model->status);
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, Tour $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/tours/active', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-play", 'style' => 'color: #ffc107']);
                                    return Html::a($icon, $url, [
                                        'title' => 'Активировать',
                                        'aria-label' => 'Активировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите Активировать ' . $model->name . '?',
                                        'data-method' => 'post',
                                    ]);
                                }
                            },
                            'delete' => function ($url, Tour $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/tours/lock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-lock", 'style' => 'color: #dc3545;']);
                                    return Html::a($icon, $url, [
                                        'title' => 'Заблокировать',
                                        'aria-label' => 'Заблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите заблокировать ' . $model->name . '?',
                                        'data-method' => 'post',
                                    ]);
                                }
                                if ($model->isLock()) {
                                    $url = Url::to(['/tours/unlock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-unlock", 'style' => 'color: #28a745']);
                                    return Html::a($icon, $url, [
                                        'title' => 'Разблокировать',
                                        'aria-label' => 'Разблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Разблокировать ' . $model->name . '?',
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