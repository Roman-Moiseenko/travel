<?php

use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\stays\StayHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\LegalWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $stay Stay */
/* @var $SearchStayForm array */


$this->registerMetaTag(['name' => 'description', 'content' => Html::encode(StringHelper::truncateWords(strip_tags($stay->getDescription()), 20))]);

$this->title = $stay->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Все аппартаменты'), 'url' => Url::to(['stays/index', 'SearchStayForm' => $SearchStayForm])];

$_city = $SearchStayForm;
$_city['city'] = $stay->city;

$this->params['breadcrumbs'][] = ['label' => Lang::t($stay->city), 'url' => Url::to(['stays/index', 'SearchStayForm' => $_city])];
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
MapAsset::register($this);

$mobile = SysHelper::isMobile();

?>

    <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col-sm-12">
            <ul class="thumbnails">
                <?php foreach ($stay->photos as $i => $photo): ?>
                    <?php if ($i == 0): ?>
                        <li>
                            <div itemscope itemtype="http://schema.org/ImageObject">
                                <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">
                                    <img src="<?= $photo->getThumbFileUrl('file', 'catalog_stays_main'); ?>"
                                         alt="<?= Html::encode($stay->getName()); ?>" class="card-img-top"
                                         itemprop="contentUrl"/>
                                </a>
                                <meta itemprop="name" content="Прокат транспорта в Калининграде">
                                <meta itemprop="description" content="<?= $stay->getName() ?>">
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="image-additional">
                            <div itemscope itemtype="http://schema.org/ImageObject">
                                <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">&nbsp;
                                    <img src="<?= $photo->getThumbFileUrl('file', 'catalog_stays_additional'); ?>"
                                         alt="<?= $stay->getName(); ?>" itemprop="contentUrl"/>
                                </a>
                                <meta itemprop="name" content="Прокат транспорта в Калининграде">
                                <meta itemprop="description" content="<?= $stay->getName() ?>">
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!-- ОПИСАНИЕ -->
    <div class="row pt-2" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col-sm-12 <?= $mobile ? ' ml-2' : '' ?>">
            <!-- Заголовок Развлечения-->
            <div class="row pb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h1><?= Html::encode($stay->getName()) ?></h1>
                        </div>
                        <div class="btn-group">
                            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                    title="<?= Lang::t('В избранное') ?>"
                                    href="<?= Url::to(['/cabinet/wishlist/add-stay', 'id' => $stay->id]) ?>"
                                    data-method="post">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Описание -->
            <div class="row">
                <div class="col-sm-10 params-tour text-justify">
                    <?= Yii::$app->formatter->asHtml($stay->getDescription(), [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                    <div>
                        <p>
                        <?= Lang::t('К Вашим услугам') . ' ' . StayHelper::textRooms($stay) .
                        ' ' . Lang::t('с') . ' ' . StayHelper::textBeds($stay, false) . ', ' .
                        Lang::t('где могут расположиться') . ' ' . $stay->params->guest . ' ' . Lang::t('гостей') . '.';
                        ?></p>
                        <p>
                        <?= Lang::t('Общая площадь помещения ') . $stay->params->square . Lang::t(' кв.м.') . Lang::t(' В доме ') . $stay->params->count_floor . Lang::t(' этажей') . '.'?></p>
                        <p>
                        <?php if ($stay->params->count_kitchen == 0 && $stay->params->count_bath == 0): ?>
                            <?= Lang::t('Ванная комната и кухня не предусмотрены в жилом помещении.') ?>
                        <?php else: ?>
                            <?= ($stay->params->count_kitchen > 0)
                                ? Lang::t('К распоряжению гостей имеется ') . StayHelper::textKitchen($stay->params->count_kitchen) . (
                                    ($stay->params->count_bath > 0) ? Lang::t(', а также, ') . StayHelper::textBath($stay->params->count_bath) . '.' : '. Ванная комната отсутствует.'
                                )
                                : Lang::t('Кухня не предусмотрена. ') . (
                                    ($stay->params->count_bath > 0) ? Lang::t('К распоряжению гостей имеется ') . StayHelper::textBath($stay->params->count_bath) . '.': '<==>'
                                )?>
                        <?php endif; ?>
                        </p>
                        <p></p>
                        <p>Что поблизости:<br>
                            <?php foreach ($stay->getNearbySortCategory() as $group => $category): ?>
                                <?php foreach ($category as $name_category => $nearby_list): ?>
                                    <?= $name_category ?>
                                    <?php $n = count($nearby_list); ?>
                                    <?php foreach ($nearby_list as $i => $nearby): ?>
                                            <?= $nearby['name'] . ' на расстоянии ' . $nearby['distance'] . ' ' .  $nearby['unit'] . (($n == $i+1) ? '.' : ', ');?>
                                    <?php endforeach; ?>
                                <br>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </p>
                    </div>
                </div>

                <div class="col-sm-2">
                    <?= LegalWidget::widget(['legal' => $stay->legal]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php foreach ($stay->getComfortsSortCategory() as $i => $category): ?>
                            <i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?>
                                <?php foreach ($category['items'] as $comfort): ?>
                                    <div>
                                        <?= '&#10004;' . ' ' . $comfort['name'] . ' ' . ($comfort['pay'] == true ? '<span class="badge badge-danger">платно</span>' : '<span class="badge badge-success">free</span>') ?>
                                        <?php if ($comfort['photo'] != ''): ?>
                                            <a class="up-image" href="#"><i class="fas fa-file-image" style="color: #0c525d; font-size: 20px;"></i>
                                                <span><img src="<?= $comfort['photo'] ?>" alt=""></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
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