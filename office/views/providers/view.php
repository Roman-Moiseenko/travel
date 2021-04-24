<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\helpers\CurrencyHelper;
use booking\helpers\ForumHelper;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \booking\entities\admin\User */


/* @var $searchModel admin\forms\user\LegalSearch */
/* @var $dataProvider ProviderLegalSearch */

$this->title = 'Провайдер: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Провайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
$id = $model->id;
$js = <<<JS
$(document).ready(function() {
    let user_id = $id;
    $('body').on('change', '#set-forum-role', function () {
        let role = $(this).val();
        $.post("/providers/forum", {role: role, user_id: user_id},
            function (data) {
            console.log(data);
            }
        );  
    });
});
JS;

$this->registerJs($js);

\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <div class="form-group">
        <?php
        if ($model->status == User::STATUS_ACTIVE) {
            echo Html::a('Заблокировать', ['lock', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        if ($model->status == User::STATUS_LOCK) {
            echo Html::a('Разблокировать', ['unlock', 'id' => $model->id], ['class' => 'btn btn-success']);
        }
        ?>
        <label for="set-forum-role"> Доступ на форуме: </label>
        <select class="form-control" id="set-forum-role" style="display: inline !important; width: auto !important;">
            <?php foreach (ForumHelper::listStatus() as $code => $status): ?>
                <option value="<?= $code ?>" <?= $code == $model->preferences->forum_role ? 'selected' : '' ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select>

    </div>
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
                    [
                        'value' => CurrencyHelper::stat($model->Balance()),
                        'format' => 'raw',
                        'label' => 'Баланс',
                        'contentOptions' => ['data-label' => 'Баланс'],
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
                        'value' => function (Legal $model) {
                            return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'label' => 'Торговая марка',
                        'value' => function (Legal $model) {
                            return Html::a(Html::encode($model->caption), ['/legals/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                        'options' => ['width' => '40%',],
                    ],
                    [
                        'label' => 'Организация',
                        'value' => function (Legal $model) {
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
