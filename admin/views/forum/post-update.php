<?php

use booking\entities\admin\User;
use booking\entities\admin\forum\Post;
use booking\forms\admin\forum\MessageForm;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var  $model MessageForm */
/* @var $post Post */
/* @var $user User */

$this->title = 'Редактировать сообщение';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['/forum']];
$this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => ['/forum/category', 'id' => $post->category_id]];
$this->params['breadcrumbs'][] = ['label' => $post->caption, 'url' => ['/forum/category', 'id' => $post->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([]); ?>
<div class="card">
    <div class="card-body">
        <label>Новое сообщение</label>
        <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?>
        <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false)->widget(CKEditor::class, [
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