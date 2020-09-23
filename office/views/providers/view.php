<?php

use booking\entities\admin\User;
use booking\entities\admin\UserLegal;
use booking\helpers\OfficeUserHelper;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \booking\entities\admin\User */


/* @var $searchModel admin\forms\user\LegalSearch */
/* @var $dataProvider ProviderLegalSearch */

$this->title = 'Провайдер: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Провайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?php if ($model->status == User::STATUS_ACTIVE) {
        echo Html::a('Заблокировать', ['lock', 'id' => $model->id], ['class' => 'btn btn-primary']);
        } ?>
        <?php if ($model->status == User::STATUS_LOCK) {
            echo Html::a('Разблокировать', ['unlock', 'id' => $model->id], ['class' => 'btn btn-success']);
        } ?>

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
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан'
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'datetime',
                        'label' => 'Изменен'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'value' => $model->personal->fullname->getFullname(),
                        'label' => 'ФИО'
                    ],
                    [
                        'value' => $model->personal->phone,
                        'label' => 'Телефон'
                    ],
                    [
                        'value' => $model->personal->address->getAddress(),
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => date('d-m-Y', $model->personal->dateborn),
                        'label' => 'Дата рождения'
                    ],
                    [
                        'value' => $model->personal->position,
                        'label' => 'Должность'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'value' => function (UserLegal $model) {
                            return '';//$model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'label' => 'Торговая марка',
                        'value' => function (UserLegal $model) {
                            return Html::a(Html::encode($model->caption), ['/legals/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                        'options' => ['width' => '40%',],
                    ],
                    [
                        'label' => 'Организация',
                        'value' => function (UserLegal $model) {
                            return Html::a(Html::encode($model->name), ['/legals/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'INN',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
