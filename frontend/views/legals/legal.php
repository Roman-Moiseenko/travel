<?php

use booking\entities\admin\Contact;
use booking\entities\admin\Legal;
use booking\entities\Lang;
use booking\helpers\SlugHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\SwiperAsset;
use frontend\widgets\legal\BookingObjectWidget;
use frontend\widgets\legal\ReviewsWidget;
use yii\helpers\Html;


/* @var $legal Legal */

$this->registerMetaTag(['name' => 'description', 'content' => $legal->description]);

$this->title = $legal->caption;
$this->params['breadcrumbs'][] = $this->title;
MagnificPopupAsset::register($this);
MapAsset::register($this);
SwiperAsset::register($this);
?>

    <!-- ЛОГОТИП, ОПИСАНИЕ  -->
    <h1><?= $legal->getCaption() ?></h1>
    <div class="row" xmlns:fb="https://www.w3.org/1999/xhtml">
        <div class="col-md-8 params-tour">
            <p class="text-justify">
                <?= Yii::$app->formatter->asHtml($legal->getDescription(), [
                    'Attr.AllowedRel' => array('nofollow'),
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>
            </p>
            <?php if (count($legal->certs) != 0): ?>
                <div class="pt-3">
                    <h4><?= Lang::t('Наши награды и сертификаты') ?></h4>
                    <ul class="thumbnails">
                        <?php foreach ($legal->certs as $cert): ?>
                            <li class="image-additional">
                                <a class="thumbnail" href="<?= $cert->getImageFileUrl('file') ?>">&nbsp;
                                    <img src="<?= $cert->getThumbFileUrl('file', 'catalog_additional'); ?>"
                                         alt="<?= $cert->name; ?>" title="<?= $cert->name; ?>"/>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <img src="<?= $legal->getThumbFileUrl('photo', 'profile'); ?>" alt="<?= Html::encode($legal->name); ?>"
                 class="img-responsive">
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
                        <span class="col-8"
                              id="address"></span><?= Lang::default() ? $legal->office : SlugHelper::slug($legal->office, [
                            'separator' => ' ',
                            'lowercase' => false,
                        ]) ?>
                        <button class="btn btn-outline-secondary loader_ymap" type="button"
                                data-toggle="collapse"
                                data-target="#collapse-map"
                                aria-expanded="false" aria-controls="collapse-map">
                            <i class="fas fa-map-marker-alt"></i>
                            &#160;&#160;&#160;<?= Lang::t('Показать карту') ?>:
                        </button>
                    </div>
                </div>
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
                <div class="collapse" id="collapse-map">

                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%"
                                   value="<?= $legal->address->address ?? '' ?>" type="hidden">
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
                        <div id="map-view" style="width: 100%; height: 300px" data-zoom="5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Контакты -->
    <div class="row pt-4">
        <div class="col">
            <div class="container-hr pb-3">
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

    <!-- Юридические сведения -->
    <div class="row pt-4">
        <div class="col params-tour">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Юридические сведения') ?></div>
            </div>
            <div class="params-item-map">
                <span style="font-weight: 600;"><?= Lang::t('Наименование организации') ?></span>&#160;&#160;<?= $legal->getName() ?>
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
    <!-- Объекты бронирования -->
    <div class="row pt-4">
        <div class="col params-tour">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Бронирования от провайдера') ?></div>
            </div>
            <?= BookingObjectWidget::widget([
                'legal_id' => $legal->id,
            ]) ?>
        </div>
    </div>
    <!-- Отзывы -->
    <div class="row pt-4">
        <div class="col params-tour">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Отзывы') ?></div>
            </div>
            <?= ReviewsWidget::widget([
                'legal_id' => $legal->id,
            ]) ?>
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