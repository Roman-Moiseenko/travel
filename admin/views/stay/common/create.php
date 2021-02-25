<?php

use booking\forms\booking\stays\StayCommonForm;
use booking\helpers\stays\StayTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model StayCommonForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $this->render('_form', [
            'model' => $model,
        'form' => $form
    ])?>

    <div class="form-group p-2">
        <?= Html::submitButton('Далее >>', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

