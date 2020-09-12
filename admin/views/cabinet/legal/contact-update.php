<?php


use booking\entities\admin\user\UserLegal;
use booking\forms\admin\ContactAssignmentForm;
use booking\helpers\ContactHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model ContactAssignmentForm */
/* @var  $legal UserLegal */


$this->title = 'Контакты';
$this->params['breadcrumbs'][] = ['label' => $legal->name, 'url' => ['/cabinet/legal/view', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['/cabinet/legal/contacts', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header with-border">Новый контакт</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'contact_id')->dropDownList(ContactHelper::list(), ['prompt' => ''])->label('Вид связи') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Значение')->hint('ссылка, имя_аккаунта, email и др.') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Пояснение')->hint('например, тел.Бухгалтера') ?>
            </div>
            <div class="col-md-2 align-self-center">

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
