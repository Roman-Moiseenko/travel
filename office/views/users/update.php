<?php

use booking\entities\office\User;
use booking\forms\office\UserForm;
use booking\helpers\OfficeUserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user User */
/* @var $model UserForm */

$this->title = 'Редактирование пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<?= $this->render('_form', [
    'model' => $model,
    'new_user' => false,
    'user' => $user,
]) ?>

