<?php

use booking\entities\admin\user\UserLegal;
use booking\forms\admin\ContactAssignmentForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var  $legal UserLegal */
/* @var $model ContactAssignmentForm */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = ['label' => $legal->name, 'url' => ['/cabinet/legal/view', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header with-border">Новый контакт</div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <?= $form->field($model, 'contact_id')->dropDownList(['prompt' => ''])->label('Вид связи') ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Значение') ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Пояснение')->hint('например, тел.Бухгалтера') ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label('Ссылка')->hint('ссылка на группу, паблиг, блог ...') ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<table class="table table-striped">
    <tbody>
    <?php foreach ($legal->contactAssignment as $contact): ?>
    <tr>

    </tr>
    <?php endforeach; ?>
    </tbody>

</table>