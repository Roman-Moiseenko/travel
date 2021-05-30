<?php



/* @var $this \yii\web\View */
/* @var $price \booking\entities\office\PriceList|null */
/* @var $model \booking\forms\office\PriceListForm */

$this->title = $price->name;
$this->params['breadcrumbs'][] = ['label' => 'Прайс-лист автоплатежей', 'url' => ['/finance/price']];
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\office\PriceList;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true])->label('Сумма оплаты') ?>
                <?= $form->field($model, 'period')->dropdownList(PriceList::ARRAY_PERIOD)->label('Период') ?>

            </div>
        </div>

    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

