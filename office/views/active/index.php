<?php

use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\shops\AdShop;
use booking\entities\shops\Shop;
use booking\helpers\AdminUserHelper;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModelTours office\forms\ToursSearch */
/* @var $dataProviderTours yii\data\ActiveDataProvider */
/* @var $searchModelCars office\forms\CarsSearch */
/* @var $dataProviderCars yii\data\ActiveDataProvider */
/* @var $searchModelFuns office\forms\FunsSearch */
/* @var $dataProviderFuns yii\data\ActiveDataProvider */
/* @var $searchModelStays office\forms\StaysSearch */
/* @var $dataProviderStays yii\data\ActiveDataProvider */
/* @var $searchModelShops office\forms\ShopsSearch */
/* @var $dataProviderShops yii\data\ActiveDataProvider */
/* @var $searchModelShopsAd office\forms\AdShopsSearch */
/* @var $dataProviderShopsAd yii\data\ActiveDataProvider */

$this->title = 'Активация объектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Туры</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderTours,
                'filterModel' => $searchModelTours,
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
                        'value' => function (Tour $model) {
                            return Html::a($model->name, ['tours/view', 'id' => $model->id]);
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

<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Авто</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderCars,
                'filterModel' => $searchModelCars,
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
                        'value' => function (Car $model) {
                            return Html::a($model->name, ['cars/view', 'id' => $model->id]);
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
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, Car $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/cars/active', 'id' => $model->id]);
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
                            'delete' => function ($url, Car $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/cars/lock', 'id' => $model->id]);
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
                                    $url = Url::to(['/cars/unlock', 'id' => $model->id]);
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
        <div class="card-body">
        </div>
    </div>
</div>

<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Развлечения</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderFuns,
                'filterModel' => $searchModelFuns,
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
                        'value' => function (Fun $model) {
                            return Html::a($model->name, ['funs/view', 'id' => $model->id]);
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
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, Fun $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/funs/active', 'id' => $model->id]);
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
                            'delete' => function ($url, Fun $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/funs/lock', 'id' => $model->id]);
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
                                    $url = Url::to(['/funs/unlock', 'id' => $model->id]);
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
        <div class="card-body">
        </div>
    </div>
</div>

<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Жилища</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderStays,
                'filterModel' => $searchModelStays,
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
                        'value' => function (Stay $model) {
                            return Html::a($model->name, ['stays/view', 'id' => $model->id]);
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
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, Stay $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/stays/active', 'id' => $model->id]);
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
                            'delete' => function ($url, Stay $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/stays/lock', 'id' => $model->id]);
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
                                    $url = Url::to(['/stays/unlock', 'id' => $model->id]);
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

<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Магазины</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderShops,
                'filterModel' => $searchModelShops,
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
                        'value' => function (Shop $model) {
                            return Html::a($model->name, ['shops/view', 'id' => $model->id]);
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
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, Shop $model, $key) {
                                if ($model->isVerify()) {
                                    $url = Url::to(['/shops/active', 'id' => $model->id]);
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
                            'delete' => function ($url, Shop $model, $key) {
                                if (!$model->isLock()) {
                                    $url = Url::to(['/shops/lock', 'id' => $model->id]);
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
                                    $url = Url::to(['/shops/unlock', 'id' => $model->id]);
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
<div class="providers-list">
    <div class="card card-info">
        <div class="card-header">Витрины</div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderShopsAd,
                'filterModel' => $searchModelShopsAd,
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