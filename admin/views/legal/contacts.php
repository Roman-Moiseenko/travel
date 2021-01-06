<?php

use booking\entities\admin\ContactAssignment;
use booking\entities\admin\Legal;
use booking\forms\admin\ContactAssignmentForm;
use booking\helpers\ContactHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var  $legal Legal */
/* @var $model ContactAssignmentForm */


$this->title = 'Контакты';
$this->params['breadcrumbs'][] = ['label' => $legal->name, 'url' => ['/legal/view', 'id' => $legal->id]];
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
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">

</div>
<?php ActiveForm::end(); ?>
<div class="card card-secondary">
    <div class="card-header">Текущие контакты</div>
    <div class="card-body">
        <div class="col-md-8">
        <table class="table table-striped table-bordered table-adaptive">
            <tbody>
            <?php /* @var $contact ContactAssignment */ ?>
            <?php foreach ($legal->contactAssignment as $contact): ?>
                <tr>
                    <td width="30px" data-label="Вид связи">
                        <img src="<?= $contact->contact->getThumbFileUrl('photo', 'icon') ?>"/>
                    </td>
                    <td width="40%" data-label="Значение">
                        <?= $contact->value ?>
                    </td>
                    <td data-label="Описание">
                        <?= !empty($contact->description) ? $contact->description : '-' ?>
                    </td>
                    <td width="80px" data-label="Действия">
                        <a href="<?= Url::to(['/legal/contact-update', 'id' => $contact->id])?>" title="Изменить"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="<?= Url::to(['/legal/contact-remove', 'id' => $contact->id])?>" title="Удалить"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
        </div>
    </div>
</div>