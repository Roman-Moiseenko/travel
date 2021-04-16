<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\tours\Tour;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\shops\DeliveryHelper;
use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\StatusHelper;
use booking\helpers\tours\TourHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $shop Shop */


$this->title = $shop->name . ' / ' . $shop->name_en;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $shop->name;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $shop->status,
            'object_id' => $shop->id,
            'object_type' => BookingHelper::BOOKING_TYPE_SHOP,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($shop->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $shop->public_at) : ''?>
    </div>
</div>

<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание / Описание EN</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
            <?= Yii::$app->formatter->asHtml($shop->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= Yii::$app->formatter->asHtml($shop->description_en, [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Дополнительно</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $shop,
                'attributes' => [
                    [
                        'attribute' => 'type_id',
                        'value' => ShopTypeHelper::list()[$shop->type_id],
                        'label' => 'Тип магазина',
                    ],
                    [
                        'attribute' => 'legal_id',
                        'value' => $shop->legal->name,
                        'label' => 'Организация',
                    ],
                ],
            ]) ?>
        </div>

    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Доставка</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $shop,
                'attributes' => [
                    [
                        'value' => !$shop->delivery->onCity ? 'нет' : 'Стоимость ' . CurrencyHelper::cost($shop->delivery->costCity) . ' при заказе от ' . CurrencyHelper::stat($shop->delivery->minAmountCity),
                        'format' => 'raw',
                        'label' => 'Доставка по городу',
                    ],
                    [
                        'value' => !$shop->delivery->onPoint ? 'нет' : $shop->delivery->addressPoint->address,
                        'label' => 'Точка выдачи в городе',
                    ],
                    [
                        'value' => CurrencyHelper::stat($shop->delivery->minAmountCompany),
                        'format' => 'raw',
                        'label' => 'Отправка ТК при заказе от',
                    ],
                    [
                        'value' => $shop->delivery->period,
                        'label' => 'Периодичность отправки в неделю',
                    ],
                    [
                        'value' => implode(', ',
                            array_filter(array_map(function ($item){
                                return DeliveryHelper::list()[$item];
                            }, $shop->delivery->deliveryCompany))),
                        'label' => 'Транспортные Компании',
                    ],
                ],
            ]) ?>
        </div>

    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/shop/update/' . $shop->id]) ,['class' => 'btn btn-success']) ?>
    </div>


</div>
