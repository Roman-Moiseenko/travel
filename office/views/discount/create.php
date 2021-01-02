<?php

use booking\helpers\DiscountHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создать Промо-коды';
$this->params['breadcrumbs'][] = ['label' => 'Промо-коды', 'url' => ['/discount']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '#generate-promo', function() {
        $(this).prop('disabled', true);
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> идет генерация ...');
    });

});
JS;
$this->registerJS($js);
?>

<div class="discount-create">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'count')->textInput(['maxlength' => true])->label('Сумма бонуса')//->widget(CKEditor::class)    ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'repeat')->textInput(['maxlength' => true])->label('Кол-во промо')//->widget(CKEditor::class)    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сгенерировать', ['class' => 'btn btn-success', 'id' => 'generate-promo']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

