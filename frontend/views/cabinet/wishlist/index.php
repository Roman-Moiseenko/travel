<?php


use booking\entities\booking\WishlistItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $wishlist WishlistItemInterface[] */

$this->title = Lang::t('Избранное');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="booking">
    <?php foreach ($wishlist as $wish): ?>
        <div class="card mt-4 shadow">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div>
                        <img src="<?= $wish->getPhoto(); ?>" alt="<?= Html::encode($wish->getName()); ?>"
                             style="border-radius: 12px;"/>
                    </div>
                    <div class="flex-grow-1 align-self-center pl-4">
                        <div class="row caption-list">
                            <div class="col-12">
                                <?= BookingHelper::icons($wish->getType()) ?> <?= Html::encode($wish->getName()) ?>
                            </div>
                        </div>

                    </div>
                    <div class="ml-auto align-self-center   ">
                        <a class="caption-list" href="<?= Url::to(['cabinet/wishlist/del-tour', 'id' => $wish->getId()])?>" title="<?= Lang::t('Удалить') ?>"
                           style="position: relative; z-index: 9999;"><i class="far fa-trash-alt"></i></a>
                    </div>
                </div>
                <a class="stretched-link" href="<?= $wish->getLink() ?>"></a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (count($wishlist) == 0): ?>
        <h3><?= Lang::t('У вас нет избранных') ?></h3>
    <?php endif; ?>
</div>

