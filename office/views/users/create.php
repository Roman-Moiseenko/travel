<?php

use booking\entities\office\User;
use booking\helpers\OfficeUserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = 'Создать Пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="card">
        <div class="card-body">
            <div class="user-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                <?= $form->field($model, 'email')->textInput()->label('Почта') ?>
                <?= $form->field($model, 'password')->textInput()->label('Пароль') ?>
                <?= $form->field($model, 'role')->dropDownList(OfficeUserHelper::rolesList(), ['prompt' => ''])->label('Уровень доступа') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
