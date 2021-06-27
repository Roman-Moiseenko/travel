<?php


use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\trips\placement\Type;
use booking\helpers\trips\PlacementHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$categories = ComfortCategory::find()->all();
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
]); ?>

<div class="card">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'type_id')->dropDownList(PlacementHelper::list(), ['prompt' => ''])->label('Вид объекта') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название объекта') ?>
            </div>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')->widget(CKEditor::class) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Основные EN</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название объекта (En)') ?>
            </div>
        </div>
        <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')->widget(CKEditor::class) ?>
    </div>
</div>

<div class="comfort">

    <?php foreach ($categories as $category): ?>
        <div class="card card-secondary">
            <div class="card-header"><i class="<?= $category->image ?>"></i> <?= $category->name ?></div>
            <div class="card-body">
                <?php foreach ($model->assignComforts as $i => $assignComfortForm): ?>
                    <?php $comfort = $assignComfortForm->_comfort;
                    if ($comfort->category_id == $category->id): ?>
                        <div class="d-flex">
                            <?php
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortForm, '[' . $i . ']checked')
                                    ->checkbox()
                                    ->label($comfort->name) . '</div>';
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortForm, '[' . $i . ']comfort_id')
                                    ->textInput(['type' => 'hidden'])
                                    ->label(false) . '</div>';

                            ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header with-border">Расположение</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <?= $form->field($model->address, 'address')->
                        textInput(['maxlength' => true, 'style' => 'width:100%'])->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form->field($model->address, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                    </div>
                    <div class="col-2">
                        <?= $form->field($model->address, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group p-2">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
