<?php

use booking\helpers\FoodHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\scr;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Основные</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'description')->textarea([])->label('Описание') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'kitchens')->checkboxList(FoodHelper::listKitchen())->label('Кухня') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'categories')->checkboxList(FoodHelper::listCategory())->label('Тип заведения') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Режим работы</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-6">
                        <b>Режим дня</b>
                    </div>
                </div>
                <?php foreach ($model->workModes as $i => $mode): ?>
                    <div class="row">
                        <div class="col-sm-1">
                            <?= WorkModeHelper::week($i) ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($mode, '[' . $i . ']day_begin')->textInput(['type' => 'time'])->label(false) ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($mode, '[' . $i . ']day_end')->textInput(['type' => 'time'])->label(false) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">СЕО</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model->meta, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model->meta, 'description')->textarea([])->label('Описание') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model->meta, 'keywords')->textInput(['maxlength' => true])->label('Ключевые слова') ?>
            </div>
        </div>
    </div>

</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
