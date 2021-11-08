<?php

use booking\entities\touristic\fun\Category;
use booking\forms\touristic\fun\FunForm;

/* @var $this \yii\web\View */
/* @var $model FunForm */
/* @var $category Category */

$this->title = 'Добавить Развлечение';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view-category', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Добавить Развлечение';

?>

<?= $this->render('_form-fun', [
    'model' => $model,
]) ?>
