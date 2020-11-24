<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page booking\entities\admin\Help */
/* @var $model booking\forms\HelpForm */

$this->title = 'Редактировать страницу: ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="page-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
