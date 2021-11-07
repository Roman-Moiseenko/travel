<?php

use booking\forms\touristic\fun\CategoryForm;

/* @var $this \yii\web\View */
/* @var $model CategoryForm */

$this->title = 'Создать Категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
?>

<?= $this->render('_form-category', [
    'model' => $model,
    'category' => null,
]) ?>
