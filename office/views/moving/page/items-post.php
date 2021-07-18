<?php

use booking\entities\moving\Item;
use booking\entities\moving\Page;
use booking\forms\moving\ItemPostForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $page Page|null */
/* @var $item Item */
/* @var $model ItemPostForm */


$this->title = 'Добавить пост';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['moving/page/view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['moving/page/items', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => $item->title, 'url' => ['moving/page/item', 'id' => $page->id, 'item_id' => $item->id]];
$this->params['breadcrumbs'][] = 'Добавить пост';
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header with-border">Общие</div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true])->label('Имя') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'surname')->textInput(['maxlength' => true])->label('Фамилия') ?>
            </div>
        </div>
        <?= $form->field($model, 'message')->widget(CKEditor::class)->label('Сообщение') ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
