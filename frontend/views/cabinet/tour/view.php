<?php

/* @var $booking BookingTour */

use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $booking->name;
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;
MagnificPopupAsset::register($this);
?>
    <div class="booking-view">
        <div class="card">
            <div class="card-body shadow-sm">
                <div class="d-flex">
                <div>
                    <ul class="thumbnails">
                    <li>
                        <a class="thumbnail"
                           href="<?= $booking->calendar->tour->mainPhoto->getThumbFileUrl('file', 'catalog_origin'); ?>">
                            <img src="<?= $booking->calendar->tour->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                 alt="<?= Html::encode($booking->calendar->tour->name); ?>"/></a>
                    </li>
                </ul>
                </div>
                    <div class="flex-grow-1 align-self-center caption-list pl-3">
                        <a href="<?= Url::to(['/tours/view', 'id' => $booking->calendar->tours_id]); ?>"><?= $booking->getName()?></a>
                    </div>
                </div>
                <hr/>
                Дата + Время
                <hr/>
                Кол-во билетов Сумма <br>
                ИТОГО
                <br>
                Если статус NEW => Оплатить, Изменить, Отменить
                Если статус PAY && tour->cancelation => Отменить
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