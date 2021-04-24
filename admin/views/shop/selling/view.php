<?php

use booking\entities\Lang;
use booking\entities\shops\order\DeliveryData;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\CurrencyHelper;
use booking\helpers\shops\DeliveryHelper;
use booking\helpers\SysHelper;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order Order */

$this->title = 'Заказ #' . $order->number . ' от ' . date('d-m-Y', $order->created_at);
$this->params['id'] = $order->shop_id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $order->shop->name, 'url' => ['/shop/view', 'id' => $order->shop_id]];
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['/shop/selling', 'id' => $order->shop_id]];
$this->params['breadcrumbs'][] = $this->title;
$mobil = SysHelper::isMobile();
?>
<div class="card ml-4" style="max-width: 800px">
    <div class="card-header">
        <div class="d-flex">
            <div class="m-2 align-self-center">
                <?= StatusHistory::toHtml($order->current_status) ?>
            </div>
            <div class="m-2 align-self-center" style="color: #0c525d">
                <?= 'Заказ от ' . date('d-m-Y', $order->created_at) ?>
            </div>
            <div class="m-2 align-self-center" style="font-size: 22px; font-weight: 600;">
                <?= CurrencyHelper::stat($order->payment->getFull()) ?>
            </div>
        </div>
        <div class="d-flex">
            <div>
                <?php if ($order->deliveryData->method) {
                    if ($order->deliveryData->method == DeliveryData::METHOD_POINT) echo 'Самовывоз';
                    if ($order->deliveryData->method == DeliveryData::METHOD_CITY)
                        echo 'Доставка по городу: ' . $order->deliveryData->address_city . ', ' . $order->deliveryData->address_street;
                    if ($order->deliveryData->method == DeliveryData::METHOD_COMPANY) {
                        echo 'Доставка по России Транспортной Компанией ' . DeliveryHelper::name($order->deliveryData->company) . '<br>';
                        echo ' адрес доставки: ' . $order->deliveryData->address_city . ', ' . $order->deliveryData->address_street . '<br>';
                    }
                }
                ?>
            </div>
            <div class="ml-auto align-self-center">
                <?= $order->deliveryData->fullname ?>
                <?= $order->deliveryData->phone ?>
            </div>
        </div>
        <div style="color: #117585"> Комментарий к заказу: <?=$order->comment; ?></div>
    </div>
    <div class="card-body">
        <?php foreach ($order->items as $i => $item): ?>
            <div class="pt-2 d-flex" style="font-size: 14px">
                <div class="align-self-center p-2" style="font-weight: 600; color: #0c525d">
                    <?= $i + 1 ?>
                </div>
                <?php if (!$mobil): ?>
                    <div class="p-2" style="min-width: 80px">
                        <img src="<?= $item->product->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= Html::encode($item->product->getName()); ?>"
                             style="border-radius: 12px;" class="img-responsive"/>
                    </div>
                <?php endif; ?>
                <div class="align-self-center p-2">
                    <a href="<?= Url::to(['shop/product/view', 'id' => $item->product_id]) ?>"><?= $item->product->getName() ?></a>
                </div>
                <div class="align-self-center p-2">
                    <?= $item->quantity . ' шт x ' . CurrencyHelper::stat($item->product_cost) ?>
                </div>
                <div class="align-self-center ml-auto">
                    <?php if ($order->isNew()): ?>
                        <span class="badge badge-danger">
                            <a href="<?= Url::to(['/shop/selling/del-item', 'order' => $order->id, 'item' => $item->id])?>" style="color: white;">
                                Удалить
                            </a>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="card-footer">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],

            'action' => ['status', 'id' => $order->id],
        ]); ?>
        <?php if ($order->isNew()): ?>
            <div class="form-group field-orderform-comment">
                <label for="orderform-comment">Комментарий к заказу</label>
                <textarea id="orderform-comment" class="form-control" name="comment"></textarea>
            </div>
            <div class="d-flex">
                <div>
                    <?= Html::submitButton('Отменить', [
                        'class' => 'btn btn-warning',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => StatusHistory::ORDER_CANCELED,
                        ],
                    ]) ?>
                </div>
                <div class="ml-auto">
                    <?= Html::submitButton('Подтвердить заказ', [
                        'class' => 'btn btn-success',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => StatusHistory::ORDER_CONFIRMATION,
                        ],
                    ]) ?>
                </div>
            </div>
            * при отмене заказа, не забудьте указать причину
        <?php endif; ?>
        <?php if ($order->isPaid()): ?>
            <div class="form-group field-orderform-comment">
                <label for="orderform-comment">Комментарий к заказу</label>
                <textarea id="orderform-comment" class="form-control" name="comment"></textarea>
            </div>
            <div class="d-flex">
                <div>

                </div>
                <div class="ml-auto">
                    <?= Html::submitButton('Заказ Формируется/Изготавливается', [
                        'class' => 'btn btn-warning',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => StatusHistory::ORDER_FORMED,
                        ],
                    ]) ?>
                </div>
            </div>
            * при изготовлении или задержке в выполнении заказа, укажите в комментарии срок в днях
        <?php endif; ?>
        <?php if ($order->isFormed()): ?>
            <div class="form-group field-orderform-comment">
                <label for="orderform-comment">Комментарий к заказу</label>
                <textarea id="orderform-comment" class="form-control" name="comment"></textarea>
            </div>
            <div class="d-flex">
                <div>
                </div>
                <div class="ml-auto">
                    <?= Html::submitButton('Заказ отправлен', [
                        'class' => 'btn btn-success',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => StatusHistory::ORDER_SENT,
                        ],
                    ]) ?>
                </div>
            </div>
            * при отправке ТК укажите трек-номер отправленного заказа
        <?php endif; ?>
        <?php if ($order->isSent()): ?>
            <div class="form-group field-orderform-comment">
                <label for="orderform-comment">Файл подтверждающий отправку (Фото накладной, чека с подписью клиента при самовывозе или доставки по городу)</label>
                <?= FileInput::widget([
                        'id' => 'document',
                        'name' => 'document',
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                    ],
                ]) ?>
            </div>
            <div class="d-flex">
                <div>
                </div>
                <div class="ml-auto">
                    <?= Html::submitButton('Заказ Выполнен', [
                        'class' => 'btn btn-success',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => StatusHistory::ORDER_COMPLETED,
                        ],
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>
        <?php ActiveForm::end(); ?>
        <?php if ($order->isCompleted()):?>
        <a href="<?= $order->getUploadedFileUrl('document')?>">
            <img src="<?= $order->getThumbFileUrl('document', 'list')?>">
        </a>
        <?php endif;?>
    </div>
</div>