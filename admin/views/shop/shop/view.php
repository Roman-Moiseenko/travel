<?php

use admin\widgest\StatusActionWidget;
use booking\entities\admin\Contact;
use booking\entities\booking\tours\Tour;
use booking\entities\shops\DeliveryCompany;
use booking\entities\shops\DeliveryCompanyAssign;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\funs\WorkModeHelper;
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
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col">
        <ul class="thumbnails">
            <?php foreach ($shop->photos as $i => $photo): ?>
                <li class="image-additional"><a class="thumbnail"
                                                href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                        <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= $shop->name; ?>"/>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Дополнительно</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $shop,
            'attributes' => [
                [
                    'attribute' => 'ad',
                    'value' => $shop->isAd() ? '<span class="badge badge-info">Витрина</span>' : '<span class="badge badge-warning">Онлайн</span>',
                    'label' => 'Тип магазина',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'type_id',
                    'value' => ShopTypeHelper::list()[$shop->type_id],
                    'label' => 'Категория магазина',
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

    <?php if ($shop->ad):?>
        <div class="card card-secondary">
            <div class="card-header with-border">Режим работы / Контакты</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php foreach ($shop->workModes as $i => $workMode) {
                            if ($workMode->day_begin != '')
                                echo '' . WorkModeHelper::week($i) . ':&#160;<i class="far fa-clock"></i>&#160;' . $workMode->day_begin . ' - ' . $workMode->day_end . '<br>';
                        } ?>

                    </div>
                    <div class="col-sm-6">
                        <table class="table">
                            <tbody>
                            <?php foreach ($shop->contactAssign as $contact): ?>
                                <tr>
                                    <th width="20px"><img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/></th>
                                    <th>
                                        <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                                            <?= Html::encode($contact->value) ?>
                                        <?php else: ?>
                                            <a href="<?= $contact->contact->prefix . $contact->value ?>"
                                               target="_blank" rel="noopener noreferrer nofollow"><?= Html::encode($contact->value) ?></a>
                                        <?php endif; ?>
                                    </th>
                                    <td><?= Html::encode($contact->description) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header with-border">Адреса</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    <?php foreach ($shop->addresses as $address):?>
                        <tr>
                            <th width="20px"><i class="fas fa-map-marked"></i></th>
                            <td><?= $address->address ?></td>
                            <th width="20px"><i class="fas fa-phone-alt"></i></th>
                            <td><?= $address->phone ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
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
                            array_filter(array_map(function (DeliveryCompany $company) {return $company->name;},
                                $shop->delivery->companies))),
                        'label' => 'Транспортные Компании',
                    ],
                ],
            ]) ?>
        </div>

    </div>
    <?php endif;?>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/shop/update/' . $shop->id]) ,['class' => 'btn btn-success']) ?>
    </div>

