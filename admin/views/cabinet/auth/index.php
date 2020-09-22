<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use booking\entities\admin\User;

/* @var $user User */

$this->title = 'Аутентификация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-auth">

    <div class="card card-secondary">
        <div class="card-header">Входные данные</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= DetailView::widget([
                    'model' => $user,
                    'attributes' => [
                        [
                            'attribute' => 'username',
                            'label' => 'Логин',
                        ],
                        [
                            'attribute' => 'email',
                            'label' => 'Электронная почта',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/cabinet/auth/update',]), ['class' => 'btn btn-success']) ?>

        <?= Html::a('Сменить пароль', Url::to(['/cabinet/auth/password',]), ['class' => 'btn btn-info']) ?>
    </div>
</div>
