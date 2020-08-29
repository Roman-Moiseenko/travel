<?php


use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $bookings BookingItemInterface[] */
/* @var $active bool */
if ($active) {
    $this->title = Lang::t('Мои бронирования');
} else {
    $this->title = Lang::t('Прошедшие бронирования');
}
if (!$active)
    $this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="booking">
    <?php foreach ($bookings as $booking): ?>
        <div class="card mt-4 shadow">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div>
                        <img src="<?= $booking->getPhoto(); ?>" alt="<?= Html::encode($booking->getName()); ?>"
                             style="border-radius: 12px;"/>
                    </div>
                    <div class="flex-grow-1 align-self-center pl-4">
                        <div class="row caption-list">
                            <div class="col-12">
                                <?= BookingHelper::icons($booking->getType()) ?> <?= Html::encode($booking->getName()) ?>
                            </div>
                        </div>
                        <div class="row date-list">
                            <div class="col-3 p-1">
                                <?= Lang::t('Дата') . ': ' . date('d-m-Y', $booking->getDate()) ?>
                            </div>
                            <div class="col-3 p-1">
                                <?php if ($booking->getType() == BookingHelper::BOOKING_TYPE_TOUR)
                                    echo Lang::t('Время') . ': ' . $booking->getAdd(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml-auto align-self-center">
                        <div class="row price-list">
                            <div class="col-12">
                                <?= CurrencyHelper::get($booking->getAmount()); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?= BookingHelper::status($booking->getStatus()) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="stretched-link" href="<?= $booking->getLink() ?>"></a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (count($bookings) == 0): ?>
        <h3><?= Lang::t('У вас нет бронирований') ?></h3>
    <?php endif; ?>
</div>

<?php if ($active): ?>
<div class="d-flex justify-content-center pt-4">
    <div>
        <a href="<?= Url::to(['/cabinet/booking/history']) ?>" class="btn-lg btn-primary"><?= Lang::t('Прошедшие бронирования') ?></a>
    </div>

</div>
<?php endif; ?>
