<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\ReviewHelper;
use frontend\assets\DatepickerAsset;
use frontend\widgets\design\BtnBooking;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $tour Tour */
//DatepickerAsset::register($this);
?>

<div class="row">
    <div class="col">
        <?php if ($tour->isActive()): ?>
            <div class="card bg-booking-widget">
                <div class="card-body">

                    <p></p>
                    <?= \frontend\widgets\design\BtnPhone::widget([
                        'caption' => 'Забронировать',
                        'block' => true,
                        'phone' => $tour->legal->noticePhone,
                        'class_name' => 'd2-btn-main'
                    ]) ?>

                    <div class="pt-3" style="color: #005601; ">* Наличие экскурсии на Ваши даты уточняйте у гида</div>
                </div>
            </div>
        <?php else: ?>
            <span class="badge badge-danger" style="font-size: 16px">Экскурсия не активна!</span>

        <?php endif; ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $tour->rating]); ?>
                <a href="#review">
                    <?= ReviewHelper::text($tour->reviews) ?>
                </a>
            </p>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= LegalWidget::widget(['legal' => $tour->legal]) ?>
    </div>
</div>
