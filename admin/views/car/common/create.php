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
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Далее >>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

