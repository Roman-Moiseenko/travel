<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\office\guides\SectionForm;
use booking\forms\office\guides\TourTypeForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model SectionForm */


$this->title = 'Редактировать раздел форума';
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['/guides/forum-section']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Заголовок') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Ссылка') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

