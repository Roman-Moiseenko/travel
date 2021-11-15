<?php

use booking\forms\touristic\stay\CategoryForm;

/* @var $this \yii\web\View */
/* @var $model CategoryForm */

$this->title = 'Создать Категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
?>

<?= $this->render('_form-category', [
    'model' => $model,
    'category' => null,
]) ?>
