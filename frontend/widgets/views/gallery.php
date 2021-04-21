<?php

use booking\entities\booking\BasePhoto;
use booking\entities\Lang;
use yii\helpers\Html;

/* @var $photo BasePhoto */
/* @var $name string */
/* @var $description string */
/* @var $i integer */
/* @var $count integer */

?>

<div class="item-gallery">
    <div itemscope itemtype="https://schema.org/ImageObject">
        <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>" rel="nofollow">
            <img src="<?= $photo->getThumbFileUrl('file', ($i == 0) ? 'catalog_gallery' : ($i == 1 || $i == 2 ? 'catalog_gallery_mini' : 'widget_list')); ?>"
                 title="<?= empty($photo->getAlt()) ? Html::encode($name) : $photo->getAlt() ?>"
                 alt="<?= Html::encode($name) . '. ' . (empty($photo->getAlt()) ? $i : $photo->getAlt()) ?>"
                 class="img-responsive"/>
            <link  itemprop="contentUrl" href="<?= $photo->getThumbFileUrl('file', ($i == 0) ? 'catalog_gallery' : ($i == 1 || $i == 2 ? 'catalog_gallery_mini' : 'widget_list')); ?>">
            <?php if ($i == 2 && $count != 3):?>
                <span class="photo-overlay">
                    <span class="photo-count">+<?= $count - 3 ?></span>
                </span>
            <?php endif; ?>
        </a>
        <meta itemprop="name" content="<?= $name . '. ' . $photo->getAlt() ?>">
        <meta itemprop="description" content="<?= Html::encode(strip_tags($description)) ?>">
    </div>
</div>
