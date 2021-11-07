<?php

use booking\entities\booking\BasePhoto;
use booking\entities\Lang;
use booking\entities\touristic\fun\Category;
use frontend\assets\GalleryAsset;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $categories Category[] */
/* @var $i integer */
/* @var $profiles array */

GalleryAsset::register($this);
?>


<?php if ($mobile): ?>
    <?php foreach ($categories as $i => $category): ?>
        <div class="item-responsive item-2-29by1 button-booking-index-mobile">
            <div class="content-item">
                <a href="<?= Url::to(['funs/category', 'id' => $category->id]) ?>">
                    <img loading="lazy"  src="<?= $category->getThumbFileUrl('photo', 'mobile'); ?>" class="img-responsive" alt="<?= $category->title ?>">
                    <div class="card-img-overlay d-flex flex-column">
                        <div>
                            <h2 class="card-title"
                                style="text-align: center !important; color: white; text-shadow: black 2px 2px 1px"><?= $category->name ?></h2>
                        </div>

                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="gallery-fun">
        <?php foreach ($categories as $i => $category): ?>
            <div class="item-gallery">
                <a class="thumbnail" href="<?= Url::to(['funs/category', 'id' => $category->id]) ?>">
                    <img src="<?= $category->getThumbFileUrl('photo', $profiles[$i]); ?>"
                         title="<?= $category->title ?>"
                         alt="<?= $category->title ?>"
                         class="img-responsive-2"
                    />
                    <h2 class="text-overlay"><?= $category->name ?></h2>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>