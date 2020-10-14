<?php

use yii\grid\GridView;

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
                            return $model->personal->fullname->getFullname();
                        },
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
