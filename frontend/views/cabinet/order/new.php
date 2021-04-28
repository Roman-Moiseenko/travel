<?php

use booking\entities\Lang;
use booking\entities\shops\DeliveryCompany;
use booking\entities\shops\order\DeliveryData;
use booking\entities\shops\order\Order;
use booking\forms\shops\OrderForm;
use booking\helpers\shops\DeliveryHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $order Order  */
/* @var $model OrderForm*/
$js = <<<JS
$(document).ready(function() {
        $('.delivery-address').hide();
        $('.delivery-company').hide();    
  $('body').on('change', '#delivery-method', function() {
    let method = Number($(this).val());
    if (method === 1) {
        $('.delivery-address').hide();
        $('.delivery-company').hide();
    }
    if (method === 2) {
        $('.delivery-address').show();
        $('.delivery-company').hide();
    }
    if (method === 3) {
        $('.delivery-address').show();
        $('.delivery-company').show();
    }    
  });
});
JS;

$this->registerJs($js);
$this->title = Lang::t('Новый заказ');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои заказы'), 'url' => Url::to(['/cabinet/orders'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Lang::t('Заказ') . ' #' . $order->number ?></h1>

Информация о заказе <br>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,

]); ?>
<div class="card">
    <div class="card-body">
        <?= $form->field($model, 'method')
            ->dropdownList(DeliveryData::_list(), ['prompt' => '-- выберите способ доставки --', 'id' => 'delivery-method', 'style' => 'max-width: 250px'])
            ->label('Способ доставки') ?>
        <div class="delivery-address">
            <span class="delivery-company">
                <?= $form->field($model, 'address_index')->textInput(['style' => 'max-width: 150px'])->label('Индекс') ?>
            </span>
            <?= $form->field($model, 'address_city')->textInput(['style' => 'max-width: 300px'])->label('Город/Страна') ?>
            <?= $form->field($model, 'address_street')->textInput(['style' => 'max-width: 500px'])->label('улица, дом, кв.') ?>
            <span class="delivery-company">
                <?= $form->field($model, 'on_hands')->checkbox()->label('доставка до квартиры') ?>
            </span>
        </div>
        <div class="delivery-company">
            <?= $form->field($model, 'company')
                ->dropdownList(ArrayHelper::map($order->shop->delivery->companies,
                    function(DeliveryCompany $company) {return $company->id;},
                    function(DeliveryCompany $company) {return $company->name;}), ['prompt' => '-- выберите ТК --', 'style' => 'max-width: 250px'])
                ->label('Транспортная компания') ?>
        </div>

        <?= $form->field($model, 'fullname')->textInput(['style' => 'max-width: 500px'])->label('Получатель (ФИО)') ?>
        <?= $form->field($model, 'phone')->textInput(['style' => 'max-width: 200px'])->label('Телефон для связи') ?>
        <?= $form->field($model, 'comment')->textarea()->label('Комментарий к заказу') ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить в магазин >>', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>



