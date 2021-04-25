<?php


use booking\entities\Lang;
use frontend\widgets\RatingWidget;
use yii\helpers\Url;

/* @var $url string */
/* @var $img_name string */
/* @var $img_alt string */
/* @var $caption string */

$url_img_booking = \Yii::$app->params['staticHostInfo'] . '/files/images/landing/booking/'; //перенести куда нить в параметры

?>
<div class="item-responsive item-0-67by1">
    <div class="content-item">
        <a href="<?= Url::to([$url]) ?>">
    <img data-src="<?=$url_img_booking . $img_name?>" class="img-responsive lazyload" width="100%" height="300px" alt="<?= $img_alt ?>">
    <div class="card-img-overlay d-flex flex-column">
        <div>
            <h3 class="card-title"
                style="color: white; text-shadow: black 2px 2px 1px"><?= Lang::t($caption) ?></h3>
        </div>
        <div class="mt-auto mb-3">
            <?= RatingWidget::widget([
                'rating' => '5',
            ])?>
        </div>
    </div>
</a>
    </div>
</div>
