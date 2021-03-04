<?php

use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $stay Stay */
/* @var $SearchStayForm array */


$this->registerMetaTag(['name' =>'description', 'content' => Html::encode(StringHelper::truncateWords(strip_tags($stay->getDescription()), 20))]);

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
                                     alt="<?= Html::encode($stay->getName()); ?>" class="card-img-top" itemprop="contentUrl"/>
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
<div class="row">

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