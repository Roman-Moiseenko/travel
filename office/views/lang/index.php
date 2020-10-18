<?php

use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\helpers\DialogHelper;
use office\forms\DialogsSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения от провайдеров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-list">

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
                        'attribute' => 'ru',
                        'contentOptions' => ['data-label' => 'ru'],
                    ],
                    [
                        'attribute' => 'en',
                        'contentOptions' => ['data-label' => 'en'],
                    ],
                    [
                        'attribute' => 'pl',
                        'contentOptions' => ['data-label' => 'pl'],
                    ],
                    [
                        'attribute' => 'de',
                        'contentOptions' => ['data-label' => 'de'],
                    ],
                    [
                        'attribute' => 'fr',
                        'contentOptions' => ['data-label' => 'fr'],
                    ],
                    [
                        'attribute' => 'lt',
                        'contentOptions' => ['data-label' => 'lt'],
                    ],
                    [
                        'attribute' => 'lv',
                        'contentOptions' => ['data-label' => 'lv'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {

                                    $url = Url::to(['/', 'id' => $model->ru]);
                                    $icon = Html::tag('i', '', ['class' => "fas fa-user-lock"]);
                                    return Html::a($icon, $url, [
                                        'title' => 'Перевод',
                                        'aria-label' => 'Перевод',
                                        'data-pjax' => 0,
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
