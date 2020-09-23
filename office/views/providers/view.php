<?php

use booking\helpers\OfficeUserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \booking\entities\admin\User */

$this->title = 'Провайдер: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Провайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a('Заблокировать', ['lock', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="box">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                    'attribute' => 'id',
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
                'value' => implode(', ', OfficeUserHelper::roles($model->id)),
                'format' => 'raw',
                'label' => 'Уровень доступа'
            ],
            'password_reset_token',
            [
                'attribute' =>'created_at',
                'format' => 'datetime',
                'label' => 'Создан'
            ],
            [
                'attribute' =>'updated_at',
                'format' => 'datetime',
                'label' => 'Изменен'
            ],
            'verification_token',
        ],
    ]) ?>
    </div>
</div>
</div>
