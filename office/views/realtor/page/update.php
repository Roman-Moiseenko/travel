<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page booking\entities\realtor\Page */
/* @var $model booking\forms\realtor\PageForm */

$this->title = 'Редактировать страницу: ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->name, 'url' => ['view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="page-update">
    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
    ]) ?>
</div>
