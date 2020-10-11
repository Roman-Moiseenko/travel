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

$this->title = 'Сообщения от провайдеров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-list">

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
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
                    ],
                    [
                        'attribute' => 'id',
                        'options' => ['width' => '20px',],
                    ],

                    [
                        'attribute' => 'provider_id',
                        'value' => function (Dialog $model) {
                            return Html::a($model->admin->username . ' (' . $model->admin->personal->fullname->getFullname() . ')', ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Провайдер'
                    ],

                    [
                        'attribute' => 'theme_id',
                        'filter' => DialogHelper::getList(Dialog::PROVIDER_SUPPORT),
                        'value' => function (Dialog $model) {
                            return $model->theme->caption;
                        },
                        'format' => 'raw',
                        'label' => 'Тема',
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
