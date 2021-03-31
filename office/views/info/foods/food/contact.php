<?php

use booking\entities\foods\Food;
use booking\forms\foods\ContactAssignForm;
use booking\helpers\ContactHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model ContactAssignForm */

/* @var $food Food */


$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['/info/foods/food/index']];
$this->params['breadcrumbs'][] = ['label' => $food->name, 'url' => ['/info/foods/food/view', 'id' => $food->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin([
        'action' => ['/info/foods/food/contact', 'id' => $food->id],
        ]
); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Редактировать контакт</div>
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