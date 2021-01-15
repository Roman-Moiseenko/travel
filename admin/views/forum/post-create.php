<?php

use booking\entities\admin\User;
use booking\forms\forum\PostForm;
use booking\entities\forum\Category;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $category Category */
/* @var  $model PostForm */
/* @var $user User */

$this->title = 'Новая тема';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['/forum']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/forum/category', 'id' => $category->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([]); ?>
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Тема') ?>
            </div>
        </div>
        <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?>
        <?= $form->field($model->message, 'text')->textarea(['rows' => 6])->label(false)->widget(CKEditor::class, [
            'editorOptions' => [
                'preset' => $preset, //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            ],
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>