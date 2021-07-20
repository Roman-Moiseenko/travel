<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model booking\entities\moving\Page */

$this->title = 'Создать страницу';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
        'page' => null,
    ]) ?>
</div>
