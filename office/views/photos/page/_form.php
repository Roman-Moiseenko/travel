<?php
declare(strict_types=1);

use booking\forms\photos\PageForm;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model PageForm */

?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Заголовок</div>
            <div class="card-body">
                <?= $form->field($model, 'title')->textInput([])->label(false) ?>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header with-border">Для SEO</div>
            <div class="card-body">
                <?= $form->field($model->meta, 'title')->textInput()->label('Заголовок') ?>
                <?= $form->field($model->meta, 'description')->textarea(['rows' => 2])->label('Описание') ?>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Метки</div>
            <div class="card-body">
                <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList())->label('Выбрать') ?>
                <?= $form->field($model->tags, 'textNew')->textInput()->label('Добавить новые (через ",")') ?>
            </div>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Описание</div>
    <div class="card-body">
        <?= $form->field($model, 'description')->widget(CKEditor::class, [
            'editorOptions' => [
                'allowedContent' => true,
                'height' => 500,
            ]
        ])->label(false) ?>

    </div>
</div>
<div class="card card-default">
    <div class="card-body">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
