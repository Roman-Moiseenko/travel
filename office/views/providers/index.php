<?php

use booking\entities\admin\User;
use booking\helpers\AdminUserHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\ProvidersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Провайдеры';
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
                        'attribute' => 'username',
                        'value' => function (User $model) {
                            return Html::a($model->username, ['providers/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Логин',
                        'contentOptions' => ['data-label' => 'Логин'],
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'label' => 'Почта',
                        'contentOptions' => ['data-label' => 'Почта'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => AdminUserHelper::listStatus(),
                        'value' => function (User $model) {
                            return AdminUserHelper::status($model->status);
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                if ($model->isActive()) {
                                    $url = Url::to(['/providers/lock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-user-lock"]);
                                    return Html::a($icon, $url, [
                                        'title' => 'Заблокировать',
                                        'aria-label' => 'Заблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите заблокировать ' . $model->username . '?',
                                        'data-method' => 'post',
                                    ]);
                                }
                                if ($model->isLock()) {
                                    $url = Url::to(['/providers/unlock', 'id' => $model->id]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-unlock"]);
                                    return Html::a($icon, $url, [
                                        'title' => 'Разблокировать',
                                        'aria-label' => 'Разблокировать',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Разблокировать ' . $model->username . '?',
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