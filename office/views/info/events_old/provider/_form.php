<?php

use booking\entities\events\Provider;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\scr;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $provider Provider */

$js = <<<JS
$(document).ready(function() {
    $('body').on('change', '.work-mode-begin', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-day_begin').val() === '') $('#workmodeform-' + i + '-day_begin').val($(this).val());
        }
    });
    
    $('body').on('change', '.work-mode-end', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-day_end').val() === '') $('#workmodeform-' + i + '-day_end').val($(this).val());
        }
    });
});
JS;
$this->registerJs($js);
?>



<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-sm-12">
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
                        <?= $form->field($model, 'description')->textarea([])->label('Описание')->widget(CKEditor::class) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'description_en')->textarea([])->label('Описание')->widget(CKEditor::class) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Фото</div>
    <div class="card-body">
        <label>Прежде, чем удалять или смещать позицию фотографий, сохраните внесенные изменения!</label>
        <?php if ($provider): ?>
            <div class="row">
                <?php foreach ($provider->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $provider->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $provider->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $provider->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ?>

        <?= $form->field($model->photos, 'files[]')
            ->label(false)
            ->widget(FileInput::class, [
                'language' => 'ru',
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg', 'jpeg'],
                ],
            ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Режим работы/Контакты</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table>
                    <tr>
                        <th width="20px">
                        </th>
                        <th colspan="2">
                            <b>Режим дня</b>
                        </th>
                        <th colspan="2">
                            <b>Обед</b>
                        </th>
                    </tr>
                    <?php foreach ($model->workModes as $i => $mode): ?>
                        <tr>
                            <td>
                                <?= WorkModeHelper::week($i) ?>
                            </td>
                            <td width="50px">
                                <?= $form->field($mode, '[' . $i . ']day_begin')->textInput(['type' => 'time', 'class' => 'work-mode-begin form-control'])->label(false) ?>
                            </td>
                            <td width="50px">
                                <?= $form->field($mode, '[' . $i . ']day_end')->textInput(['type' => 'time', 'class' => 'work-mode-end form-control'])->label(false) ?>
                            </td>
                            <td width="50px">
                                <?= $form->field($mode, '[' . $i . ']break_begin')->textInput(['type' => 'time', 'class' => 'work-mode-break-begin form-control'])->label(false) ?>
                            </td>
                            <td width="50px">
                                <?= $form->field($mode, '[' . $i . ']break_end')->textInput(['type' => 'time', 'class' => 'work-mode-break-end form-control'])->label(false) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-2"><label>Соц.сеть</label></div>
                    <div class="col-4"><label>Значение</label></div>
                    <div class="col-4"><label>Описание</label></div>
                </div>
                <?php foreach ($model->contactAssign as $i => $assignForm): ?>
                    <div class="row">
                        <div class="col-2"><img
                                    src="<?= $assignForm->_contact->getThumbFileUrl('photo', 'icon') ?>"></div>
                        <div class="col-4"><?= $form->field($assignForm, '[' . $i . ']value')->textInput()->label(false) ?></div>
                        <div class="col-4"><?= $form->field($assignForm, '[' . $i . ']description')->textInput()->label(false) ?></div>
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
