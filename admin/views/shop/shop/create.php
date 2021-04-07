<?php

use booking\forms\booking\tours\TourCommonForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */

$this->title = 'Создать Магазин (Онлайн)';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">

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

