<?php

use booking\forms\office\UserForm;

/* @var $this yii\web\View */
/* @var $model UserForm */

$this->title = 'Создать Пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'new_user' => true,
    'user' => null,
]) ?>

