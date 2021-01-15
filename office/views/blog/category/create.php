<?php

use booking\entities\blog\Category;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Category */

$this->title = 'Создать Категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
