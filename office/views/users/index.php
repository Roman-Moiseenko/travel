<?php

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

use booking\helpers\OfficeUserHelper;
use office\widgets\RoleColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="users-list">
    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'options' => ['width' => '20px',]
                    ],
                    [
                        'attribute' => 'username',
                        'format' => 'text',
                        'label' => 'Логин'
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'label' => 'Почта'
                    ],
                    [
                        'attribute' =>'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                    ],
                    [
                        'attribute' => 'role',
                        'label' => 'Роль',
                        'class' => RoleColumn::class,
                        'filter' => OfficeUserHelper::rolesList(),
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>