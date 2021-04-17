<?php


use booking\entities\admin\Legal;
use booking\entities\foods\Food;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\InfoAddressForm;
use booking\helpers\ContactHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model InfoAddressForm */
/* @var  $food Food */


$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['/info/foods/food']];
$this->params['breadcrumbs'][] = ['label' => $food->name, 'url' => ['/info/foods/food/view', 'id' => $food->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Добавить адрес</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>
                </div>
                <div class="col-8">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'id' => 'staycommonform-city'])->label('Город') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model, 'address')->
                    textInput(['maxlength' => true, 'style' => 'width:100%', 'id' => 'bookingaddressform-address'])->label('Адрес') ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true, 'id' => 'bookingaddressform-latitude'])->label('Широта') ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true, 'id' => 'bookingaddressform-longitude'])->label('Долгота') ?>
                </div>

            </div>
            <div class="row">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>