<?php

use booking\entities\admin\Contact;
use booking\entities\admin\Legal;
use booking\entities\Lang;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\shops\ShopTypeHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $shop Shop */


$this->title = 'Магазин: ' . $shop->name;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($shop->isVerify()) {
                echo Html::a('Активировать', ['active', 'id' => $shop->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($shop->isLock()) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $shop->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $shop->id], ['class' => 'btn btn-danger']);
            }
            ?>

        </p>
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
        <div class="card">
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $shop,
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'label' => 'ID',
                        ],
                        [
                            'attribute' => 'ad',
                            'format' => 'raw',
                            'value' => $shop->isAd() ? '<span class="badge badge-info">Витрина</span>' : '<span class="badge badge-warning">Онлайн</span>',
                            'label' => 'Тип',
                        ],
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => $shop->isAd()
                                ? 'Бесплатные места: ' . $shop->free_products . ' / Оплаченные места: ' . $shop->active_products . ' / Бюджет: ' . CurrencyHelper::stat($shop->user->Balance())
                                : '',
                            'label' => 'Доступные товары',
                        ],
                        [
                            'attribute' => 'name',
                            'format' => 'text',
                            'label' => 'Название',
                        ],
                        [
                            'attribute' => 'description',
                            'value' => function (Shop $model) {
                                return Yii::$app->formatter->asHtml($model->description, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]);
                            },
                            'format' => 'raw',
                            'label' => 'Описание',
                        ],
                        [
                            'attribute' => 'name_en',
                            'format' => 'text',
                            'label' => 'Название (En)',
                        ],
                        [
                            'attribute' => 'description_en',
                            'value' => function (Shop $model) {
                                return Yii::$app->formatter->asHtml($model->description_en, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]);
                            },
                            'label' => 'Описание (En)',
                        ],
                        [
                            'attribute' => 'type_id',
                            'value' => ShopTypeHelper::list()[$shop->type_id],
                            'label' => 'Категория',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($shop) {
                                $legal = Legal::findOne($shop->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $shop->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Провайдер',
                            'value' => function () use ($shop) {
                                return Html::a($shop->user->username, ['providers/view', 'id' => $shop->user_id]);
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?php if ($shop->isAd()): ?>
                        <div class="pt-2 pb-1" style="font-size: 16px"><?= Lang::t('Режим работы') ?>:</div>
                        <?php foreach ($shop->workModes as $i => $workMode) {
                            if ($workMode->day_begin != '')
                                echo '&#160;&#160;' . WorkModeHelper::week($i) . ':&#160;<i class="far fa-clock"></i>&#160;' . $workMode->day_begin . ' - ' . $workMode->day_end . '<br>';
                        } ?>
                    <div>Адреса:</div>
                    <?php foreach ($shop->addresses as $address) {
                        echo '<div class="pl-3"><i class="fas fa-map-marker-alt"></i>&#160;' . $address->address . '&#160;&#160;<i class="fas fa-phone-alt"></i>' . $address->phone . '</div>';
                    } ?>
                    <?php if (count($shop->contactAssign) > 0): ?>
                        <div class="pt-2"><?= Lang::t('Контакты:') ?></div>
                    <?php endif; ?>
                    <?php foreach ($shop->contactAssign as $contact): ?>
                        <div class="pl-3">
                            <img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/>&#160;
                            <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                                <?= Html::encode($contact->value) ?>
                            <?php else: ?>
                                <a href="<?= $contact->contact->prefix . $contact->value ?>"
                                   target="_blank" rel="nofollow"><?= Html::encode($contact->value) ?></a>
                            <?php endif; ?>
                            &#160;<?= Html::encode($contact->description) ?>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="pt-3 pb-1">
                        <?= Lang::t('Магазин') . ' ' . $shop->getName() . Lang::t(' осуществляет доставку по России следующими ТК:') ?>
                        <?php foreach ($shop->delivery->companies as $company): ?>
                            <div class="pl-3"><a class="" href="<?= $company->link?>" target="_blank" rel="noreferrer noopener nofollow"><?= $company->name; ?></a></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pl-3">
                        <?= Lang::t('Минимальная сумма заказа для доставки в регионы: ') . CurrencyHelper::stat($shop->delivery->minAmountCompany) ?>
                    </div>
                    <div class="pl-3">
                        <?php if ($shop->delivery->period == 0): ?>
                            <?= Lang::t('Отправка осуществляется в день заказа ') ?>
                        <?php else: ?>
                            <?= Lang::t('Отправка товара производится ') . $shop->delivery->period . Lang::t(' раз в неделю') ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($shop->delivery->onCity): ?>
                        <div class="pt-3 pb-1">
                            <?= Lang::t('Имеется доставка по городу Калининград: ') ?>
                        </div>
                        <div class="pl-3">
                            <?= Lang::t('Минимальная сумма заказа для доставки ') . CurrencyHelper::stat($shop->delivery->minAmountCity) ?>
                            <br>
                            <?= Lang::t('Стоимость доставки ') . CurrencyHelper::cost($shop->delivery->costCity) ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($shop->delivery->onPoint): ?>
                        <div class="pt-3 pb-1">
                            <?= 'Точка выдачи в КО: ' . $shop->delivery->addressPoint->address ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Товары</div>
        <div class="card-body">
            <table class="table table-adaptive table-striped">
                <tr></tr>
                <?php foreach ($shop->products as $i => $product): ?>
                    <tr>
                        <td width="20px"><?= $i + 1 ?></td>
                        <td><img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'admin') ?>"></td>
                        <td><a href="<?= Url::to(['/shops/product', 'id' => $product->id])?>"><?= $product->name ?></a></td>
                        <td><?= CurrencyHelper::stat($product->cost) ?></td>
                        <td><?= $product->views ?></td>
                        <td><?= $product->buys ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>