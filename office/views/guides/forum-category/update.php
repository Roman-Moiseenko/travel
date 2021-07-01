<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\admin\forum\CategoryForm;
use booking\forms\office\guides\TourTypeForm;
use booking\helpers\ForumHelper;
use booking\helpers\UserForumHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model CategoryForm */


$this->title = 'Редактировать Категорию форума';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/guides/forum-category']];
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
                    <?= $form->field($model, 'section_id')->dropdownList(UserForumHelper::listSection(), ['prompt' => ''])->label('Раздел форума') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название Категории') ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'description')->textarea()->label('Описание') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

