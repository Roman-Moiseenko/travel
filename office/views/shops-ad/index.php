<?php

use booking\entities\shops\AdShop;
use booking\entities\shops\Shop;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\AdShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Магазины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-list">
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
                        'attribute' => 'name',
                        'value' => function (AdShop $model) {
                            return Html::a($model->name, ['shops-ad/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Название',
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StatusHelper::listStatus(),
                        'value' => function (AdShop $model) {
                            return StatusHelper::statusToHTML($model->status);
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, AdShop $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/shops-ad/active', 'id' => $model->id]);
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
                            'delete' => function ($url, AdShop $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/shops-ad/lock', 'id' => $model->id]);
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
                                    $url = Url::to(['/shops-ad/unlock', 'id' => $model->id]);
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