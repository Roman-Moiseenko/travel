<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мои организации';
$this->params['breadcrumbs'][] = $this->title;

/* @var $user User */
/* @var $searchModel admin\forms\user\LegalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="user-legal">

    <p>
        <?= Html::a('Создать Организацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-adaptive table-striped table-bordered',

                ],
                'columns' => [
                    [
                        'value' => function (Legal $model) {
                            return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Логотип'],
                        'options' => ['width' => '100px'],
                    ],
                    [
                        'label' => 'Торговая марка',
                        'value' => function (Legal $model) {
                            return Html::a(Html::encode($model->caption), ['/cabinet/legal/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                        'options' => ['width' => '40%',],
                        'contentOptions' => ['data-label' => 'Торговая марка'],
                    ],
                    [
                        'label' => 'Организация',
                        'value' => function (Legal $model) {
                            return Html::a(Html::encode($model->name), ['/cabinet/legal/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                        'contentOptions' => ['data-label' => 'Организация'],
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'INN',
                        'contentOptions' => ['data-label' => 'ИНН'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                                return Html::a($icon, $url, [
                                    'title' => 'Обзор',
                                    'aria-label' => 'Обзор',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                return Html::a($icon, $url, [
                                    'title' => 'Изменить',
                                    'aria-label' => 'Изменить',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                                return Html::a($icon, $url, [
                                    'title' => 'Удалить',
                                    'aria-label' => 'Удалить',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Вы уверены, что хотите удалить организацию ' . $model->name . '?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
