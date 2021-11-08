<?php

use booking\entities\touristic\fun\Category;
use booking\entities\touristic\fun\Fun;
use booking\forms\touristic\fun\FunForm;

/* @var $this \yii\web\View */


/* @var $fun Fun */
/* @var $model FunForm */
/* @var $category Category */
$this->title = 'Редактировать ' . $fun->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view-category', 'id' => $category->id]];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['view-fun', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<?=
$this->render('_form-fun', [
    'model' => $model,
])
?>