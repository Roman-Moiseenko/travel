<?php

use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\helpers\DialogHelper;
use office\forms\DialogsSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\DialogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения от клиентов';
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
                        'value' => function (Dialog $model) {
                            $countNew = $model->countNewConversation();
                            if ($countNew == 0) {
                                return '<i class="far fa-envelope-open"></i>';
                            }
                            return '<i class="fas fa-envelope"></i> <span class="badge badge-danger">' . $countNew . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['width' => '70px',],
                        'contentOptions' => ['data-label' => 'Сообщения'],
                    ],
                    [
                        'attribute' => 'id',
                        'options' => ['width' => '20px',],
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => function (Dialog $model) {
                            return Html::a($model->user->username . ' (' . $model->user->personal->fullname->getFullname() . ')', ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Клиент',
                        'contentOptions' => ['data-label' => 'Клиент'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                    [
                        'attribute' => 'theme_id',
                        'filter' => DialogHelper::getList(Dialog::CLIENT_SUPPORT),
                        'value' => function (Dialog $model) {
                            return $model->theme->caption;
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
