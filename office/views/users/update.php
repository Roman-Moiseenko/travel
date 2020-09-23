<?php

use booking\entities\office\User;
use booking\helpers\OfficeUserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $user User */
/* @var $model UserEditForm */

$this->title = 'Редактирование пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="user-update">

    <div class="card">
        <div class="card-body">
            <div class="user-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                <?= $form->field($model, 'email')->textInput()->label('Эл.почта') ?>
                <?= $form->field($model, 'password')->textInput()->label('Пароль')->hint('Оставьте пустым, если не хотите менять.') ?>
                <?= $form->field($model, 'role')->dropDownList(OfficeUserHelper::rolesList())->label('Уровень доступа') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
