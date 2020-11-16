<?php

use booking\forms\booking\cars\CarCommonForm;
use booking\helpers\cars\CarTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CarCommonForm */

$this->title = 'Создать Авто';
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

