<?php

use booking\forms\photos\PageForm;


/* @var $this \yii\web\View */
/* @var $model PageForm */
$this->title = 'Добавить Публикацию';
$this->params['breadcrumbs'][] = ['label' => 'Публикации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
