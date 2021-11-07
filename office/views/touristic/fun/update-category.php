<?php

use booking\entities\touristic\fun\Category;
use booking\forms\touristic\fun\CategoryForm;


/* @var $this \yii\web\View */
/* @var $category Category|null */
/* @var $model CategoryForm */
$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view-category', 'id' => $category->id]];
 ?>

<?= $this->render('_form-category', [
    'model' => $model,
    'category' => $category,
]) ?>