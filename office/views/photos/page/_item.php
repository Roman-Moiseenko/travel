<?php

use booking\entities\Lang;
use booking\entities\photos\Item;
use booking\forms\photos\ItemForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ItemForm */
/* @var $item Item */
/* @var $page_id int */




?>

<?php $form = empty($item) ?
    ActiveForm::begin(['action' => ['add-item', 'id' => $page_id],]) :
    ActiveForm::begin(['action' => ['edit-item', 'id' => $page_id, 'item_id' => $item->id],]); ?>

<div class="modal-body">
    <?= $form->field($model, 'name')->textInput(/*['readonly' => true]*/)->label('Заголовок фотографии') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 4])->label('Описание фотографии')->hint('* Необязательное поле') ?>

    <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
        'language' => Lang::current(),
        'bsVersion' => '4.x',
        'options' => [
            'accept' => 'image/*',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'initialPreview' => [
               $item ? $item->getThumbFileUrl('photo', 'thumb') : null,
            ],
            'initialPreviewAsData' => true,
            'overwriteInitial' => true,
            'showRemove' => false,
        ],
    ]) ?>
</div>
<div class="modal-footer">
    <div class="form-group">
        <?= Html::submitButton(empty($item) ? 'Добавить': 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
