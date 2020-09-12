<?php

use booking\entities\admin\user\Contact;
use booking\entities\admin\user\UserLegal;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\ToursHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $legal UserLegal */

$this->title = $legal->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- ЛОГОТИП, ОПИСАНИЕ  -->
<h1><?= $legal->caption ?></h1>
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col-md-7 params-tour">
        <p class="text-justify">
            <?= Yii::$app->formatter->asHtml($legal->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </p>
    </div>
    <div class="col-md-5">
        <img src="<?= $legal->getThumbFileUrl('photo', 'profile'); ?>" alt="<?= Html::encode($legal->name); ?>"/>
    </div>
</div>

<!-- Адрес -->
<div class="row pt-4">
    <div class="col">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Адрес') ?></div>
        </div>
        <div class="params-item-map">
            <div class="row pt-2 pb-4">
                <div class="col">
                    <?= $legal->address->address; ?>,&#160;<?= $legal->office; ?>
                </div>
            </div>
            <div class="row">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%"
                                   value="<?= $legal->address->address ?? ' ' ?>" type="hidden">
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                   value="<?= $legal->address->latitude ?? '' ?>" type="hidden">
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                   value="<?= $legal->address->longitude ?? '' ?>" type="hidden">
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view" style="width: 100%; height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Контакты -->
<div class="row pt-4">
    <div class="col">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Контакты') ?></div>
        </div>
        <table class="table">
            <tbody>
            <?php foreach ($legal->contactAssignment as $contact): ?>
                <tr>
                    <th width="20px"><img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/></th>
                    <th>
                        <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                            <?= Html::encode($contact->value) ?>
                        <?php else: ?>
                            <a href="<?= $contact->contact->prefix . $contact->value ?>"><?= Html::encode($contact->value) ?></a>
                        <?php endif; ?>
                    </th>
                    <td><?= Html::encode($contact->description) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Юридические сведения -->
<div class="row pt-4">
    <div class="col params-tour">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Юридические сведения') ?></div>
        </div>
        <div class="params-item-map">
            <span style="font-weight: 600;"><?= Lang::t('Наименование организации') ?></span>&#160;&#160;<?= $legal->name ?>
        </div>
        <div class="params-item-map">
            <span style="font-weight: 600;"><?= Lang::t('ИНН') ?></span>&#160;&#160;<?= $legal->INN ?>
        </div>
        <div class="params-item-map">
            <span style="font-weight: 600;"><?= Lang::t('ОГРН') ?></span>&#160;&#160;<?= $legal->OGRN ?>
        </div>
        <div class="params-item-map">
            <span style="font-weight: 600;"><?= Lang::t('БИК банка') ?></span>&#160;&#160;<?= $legal->BIK ?>
        </div>
        <div class="params-item-map">
            <span style="font-weight: 600;"><?= Lang::t('Расчетный счет') ?></span>&#160;&#160;<?= $legal->account ?>
        </div>
    </div>
</div>
