<?php


use booking\entities\art\event\Category;
use booking\forms\art\event\CategoryForm;

/* @var $this \yii\web\View */
/* @var $category Category|null */
/* @var $model CategoryForm */
$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Категории Событий', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];

 ?>

<?= $this->render('_form', [
    'model' => $model,
    'category' => $category,
]) ?>