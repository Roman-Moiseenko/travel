<?php

use booking\helpers\OfficeUserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \booking\entities\office\User */

$this->title = 'Пользователь: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="card">
    <div class="card-body">
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
            [
                'attribute' =>'person_surname',
                'label' => 'Фамилия'
            ],
            [
                'attribute' =>'person_firstname',
                'label' => 'Имя'
            ],
            [
                'attribute' =>'person_secondname',
                'label' => 'Отчество'
            ],
            [
                'attribute' =>'description',
                'format' => 'text',
                'label' => 'Описание'
            ],
            [
                'attribute' =>'home_page',
                'value' => '<a href="' . $model->home_page . '">' . $model->home_page . '</a>',
                'format' => 'raw',
                'label' => 'Ссылка'
            ],
        ],
    ]) ?>
    </div>
</div>
    <?php if (!empty($model->photo)): ?>
        <img src="<?= Html::encode($model->getThumbFileUrl('photo', 'profile')) ?>" alt=""
             class="img-responsive" style="max-width:100%;height:auto;"/>
    <?php else: ?>
        <img src="<?= Url::to('@static/files/images/no_user.png') ?>" alt=""
             class="img-responsive" style="max-width:100%;height:auto;"/>
    <?php endif; ?>

</div>
