<?php

use booking\entities\admin\Contact;
use booking\entities\Lang;
use booking\entities\shops\Shop;
use booking\helpers\CurrencyHelper;
use frontend\assets\MapAsset;
use yii\helpers\Html;

/* @var $shop Shop */
/* @var $sale_on bool */

MapAsset::register($this);
?>

<?php if ($shop->isAd()): ?>
    <div>Товар можно приобрести по адресу:</div>
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
    <div class="row pt-4">
        <div class="col">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
            <span id="count-points" data-count="<?= count($shop->addresses) ?>"></span>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-4">

                        <button class="btn btn-outline-secondary loader_ymap" type="button"
                                data-toggle="collapse"
                                data-target="#collapse-map-3"
                                aria-expanded="false" aria-controls="collapse-map-2">
                            <i class="fas fa-map-marked-alt"></i>&#160;<?= Lang::t('Показать на карте') ?>
                        </button>
                        <?php foreach ($shop->addresses as $i => $address): ?>
                            <input type="hidden" id="address-<?= $i + 1 ?>" value="<?= $address->address ?>">
                            <input type="hidden" id="phone-<?= $i + 1 ?>" value="<?= $address->phone ?>">
                            <input type="hidden" id="latitude-<?= $i + 1 ?>" value="<?= $address->latitude ?>">
                            <input type="hidden" id="longitude-<?= $i + 1 ?>" value="<?= $address->longitude ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="pt-3 collapse" id="collapse-map-3">
                    <div class="card card-body card-map">
                        <div class="row">
                            <div id="map-food-view" style="width: 100%; height: 450px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($sale_on): ?>
    <?php if (!empty($shop->delivery->arrayCompanies)): ?>
        <div class="pt-3 pb-1" style="font-size: 13px;">
            <?= Lang::t('Магазин') . ' ' . $shop->getName() . Lang::t(' осуществляет доставку по России следующими ТК:') ?>
            <?php foreach ($shop->delivery->getCompanies() as $company): ?>
                <div class="pl-3"><a class="" href="<?= $company->link ?>" target="_blank"
                                     rel="noreferrer noopener nofollow"><?= $company->name; ?></a></div>
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
        <div class="pl-3 attention">
            <?= Lang::t('Внимание! Доставку Транспортной компанией Клиент оплачивает самостоятельно! Стоимость Вы можете расчитать на сайте ТК') ?>
        </div>
    <?php endif; ?>
    <?php if ($shop->delivery->onCity): ?>
        <div class="pt-3 pb-1" style="font-size: 13px;">
            <?= Lang::t('Имеется доставка по городу Калининград: ') ?>
        </div>
        <div class="pl-3">
            <?= Lang::t('Минимальная сумма заказа для доставки ') . CurrencyHelper::stat($shop->delivery->minAmountCity) ?>
            <br>
            <?= Lang::t('Стоимость доставки ') . CurrencyHelper::cost($shop->delivery->costCity) ?>
        </div>
    <?php endif; ?>
    <?php if ($shop->delivery->onPoint): ?>
        <div class="pt-3 pb-1" style="font-size: 13px;">
            <?= Lang::t('Имеется возможность самостоятельно забрать заказ в Калининграде') ?>
        </div>
    <?php endif; ?>
    <span class="mt-3 badge badge-success"
          style="font-size: 12px"><?= Lang::t('Защищенный платеж') ?></span> - <?= Lang::t('продавец получит деньги после отправки заказа покупателю') ?>
<?php endif; ?>

