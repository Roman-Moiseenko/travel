<?php

use booking\forms\art\event\CategoryForm;

/* @var $this \yii\web\View */
/* @var $model CategoryForm */

$this->title = 'Создать Категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории Событий', 'url' => ['index']];
?>

<?= $this->render('_form', [
    'model' => $model,
    'category' => null,
]) ?>
