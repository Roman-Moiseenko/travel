<?php

use booking\entities\shops\cart\Cart;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cart Cart */

$js = <<<JS
$(document).ready(function() {
    let _check = 0;
    $('body').on('keydown', '.only_int', function(e) {
     if (e.key !== '0' && e.key !== '1' && e.key !== '2' && e.key !== '3' &&
         e.key !== '4' && e.key !== '5' && e.key !== '6' && e.key !== '7' &&
          e.key !== '8' && e.key !== '9') {
         return false;
     } 
    });
    $('body').on('keyup', '.only_int', function(e) {
     /* ВОЗМОЖНО: Убрать форму, считать Id, новое quantity и отправить post в cart/quantity */ 
  });
});
JS;
$this->registerJs($js);

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => '/shops'];
$this->params['breadcrumbs'][] = $this->title;
$mobil = SysHelper::isMobile();

?>
<?php if ($cart->getItems()): ?>
    <div class="row">
        <div class="col-lg-8 col-md-7">
            <?php foreach ($cart->getItems() as $item): ?>
                    <?= Html::beginForm(['quantity', 'id' => $item->getId()]); ?>
                    <?php
                    $product = $item->getProduct();
                    $url = Url::to(['/shop/catalog/product', 'id' => $product->id]); ?>
                    <div class="card list-cart">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-sm-6 align-self-center pl-4">
                                    <div class="d-flex">
                                        <?php if (!$mobil): ?>
                                        <div style="min-width: 80px">
                                            <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                                 alt="<?= Html::encode($product->getName()); ?>"
                                                 style="border-radius: 12px;" class="img-responsive"/>
                                        </div>
                                    <?php endif; ?>
                                        <div class="">
                                            <div class="col-12">
                                                <a class="list-cart-caption" href="<?= $url ?>"><?= Html::encode($product->getName()) ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 align-self-center <?= $mobil ? 'pt-4' : 'pl-4'?>">
                                    <div class="d-flex">
                                        <div class="mr-auto align-self-center pl-4">
                                            <div class="count-btn" style="display: flex; width: 91px">
                                                <button title="minus" class="count-buttons__button count-buttons__button_minus"
                                                   href="<?= ($item->getQuantity() == 1)
                                                       ? Url::to(['remove', 'id' => $item->getId()])
                                                       : Url::to(['sub', 'id' => $item->getProductId()]) ?>" data-method="post">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="text" name="quantity" value="<?= $item->getQuantity() ?>"
                                                       size="1" class="count-buttons__input only_int" onkeyup="this.form.submit()"/>
                                                <button title="plus" class="count-buttons__button count-buttons__button_plus"
                                                   href="<?= Url::to(['add', 'id' => $item->getProductId()]) ?>" data-method="post">
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="align-self-center pl-4">
                                            <span style="font-size: 16px; color: #353535"><?= CurrencyHelper::stat($item->getCost()) ?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::endForm() ?>
                <?php endforeach; ?>
        </div>
        <div class="col-lg-4 col-md-5">
            <div class="card list-cart">
                <div class="card-body">
                    <?php $cost = $cart->getCost() ?>
                        <div class="text-left p-3" style="font-size: 17px; color: #272727">
                            <span>Итого: <?= $cart->getAmount() ?> товаров на <?= CurrencyHelper::stat($cost->getTotal()) ?></span>
                        </div>
                    <div class="pt-4 text-center"><a href="<?= Url::to('/shop/checkout/index') ?>"
                                         class="btn-lg btn-primary form-control" style="height: 43px"><?= Lang::t('Оформить заказ') ?></a></div>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>