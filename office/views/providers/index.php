<?php

$this->title = 'Провайдеры';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\admin\User;
use booking\helpers\OfficeUserHelper;
use office\widgets\RoleColumn;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel office\forms\ProvidersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="providers-list">

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
                        'value' => function (User $model) {
                            return Html::a($model->username, ['providers/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
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
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>