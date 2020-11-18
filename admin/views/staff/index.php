<?php

use booking\entities\check\User;
use booking\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">
    <p>
        <?= Html::a('Добавить Сотрудника', Url::to(['create']), ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'username',
                'label' => 'Логин',
                'value' => function (User $model) {
                    return Html::a($model->username, Url::to(['view', 'id' => $model->id]));
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Логин'],
            ],
            [
                'attribute' => 'fullname',
                'label' => 'ФИО',
                'contentOptions' => ['data-label' => 'ФИО'],
            ],
            [
                'attribute' => 'box_office',
                'label' => 'Точка продаж',
                'contentOptions' => ['data-label' => 'Точка продаж'],
            ],
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
                'contentOptions' => ['data-label' => 'Телефон'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, User $model, $key) {
                        if ($model->isActive()) {
                            $url = Url::to(['lock', 'id' => $model->id]);
                            $icon = Html::tag('i', '', ['class' => "fas fa-lock", 'style' => 'color: #dc3545;']);
                            return Html::a($icon, $url, [
                                'title' => 'Заблокировать',
                                'aria-label' => 'Заблокировать',
                                'data-pjax' => 0,
                                'data-confirm' => 'Вы уверены, что хотите заблокировать ' . $model->username . '?',
                                'data-method' => 'post',
                            ]);
                        }
                        if (!$model->isActive()) {
                            $url = Url::to(['unlock', 'id' => $model->id]);
                            $icon = Html::tag('i', '', ['class' => "fas fa-unlock", 'style' => 'color: #28a745']);
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
    <span>* Адрес для входа сотрудникам - <a href="http://check.koenigs.ru" target="_blank">check.koenigs.ru</a> Оптимизирован под мобильные телефоны</span>
</div>
