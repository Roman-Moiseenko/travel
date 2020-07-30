<?php

use booking\entities\admin\user\User;
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
                'columns' => [
                    [
                        'label' => 'Наименование',
                        'attribute' => 'name',
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'INN',
                    ],
                    [
                        'label' => 'КПП',
                        'attribute' => 'KPP',
                    ],
                    [
                        'label' => 'ОГРН',
                        'attribute' => 'OGRN',
                    ],
                    [
                        'label' => 'БИК банка',
                        'attribute' => 'BIK',
                    ],
                    [
                        'label' => 'Р/счет',
                        'attribute' => 'account',
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
