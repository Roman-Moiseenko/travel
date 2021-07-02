<?php

use booking\helpers\UserForumHelper;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-list">
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
                        'value' => function (\booking\entities\user\User $model) {
                            return '<a href="'. Url::to(['view', 'id' => $model->id]) . '">' .
                                $model->personal->fullname->getFullname() .
                                '</a> ' .
                                UserForumHelper::status($model->preferences->forum_role);
                        },
                        'format' => 'raw',
                        'label' => 'ФИО',
                        'contentOptions' => ['data-label' => 'ФИО'],
                    ],
                    [
                        'attribute' => 'username',
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
                        'attribute' => 'personal.phone',
                        'label' => 'Телефон',
                        'contentOptions' => ['data-label' => 'Телефон'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
