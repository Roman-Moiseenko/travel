<?php

use booking\entities\shops\cart\Cart;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use frontend\widgets\design\BtnToCart;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $cart Cart */
$mobil = SysHelper::isMobile();
?>
<?php if ($cart->getAmount() > 0): ?>
    <li class="<?= $mobil ? '' : 'dropdown'?> nav-item">
        <a href="<?= $mobil ? Url::to(['/shop/cart/index'])  : '/index.php'?>" class="<?= $mobil ? '' : 'dropdown-toggle'?> nav-link"
           <?= $mobil ? '' : 'data-toggle="dropdown"'?>  rel="nofollow"><i class="fa fa-shopping-cart"></i>
            <span id="cart-total" class="badge badge-warning" style="font-size: 11px"><?=$cart->getAmount();?></span></a>
        <div class="dropdown-menu cart-widget">
            <div class="cart-summary p-2" style="font-size: 16px">
                <div class="d-flex">
                    <div class="text-right"><?= Lang::t('Товары') ?> <?= $cart->getAmount()?></div>
                    <div class="ml-auto text-right">Итого: <?= CurrencyHelper::get($cart->getCost()->getTotal()) ?></div>
                </div>
            </div>
            <div class="cart-scrollable">
            <table class="table" style="width: 500px;">
                <?php foreach ($cart->getItems() as $item): ?>
                    <?php
                    $product = $item->getProduct();
                    $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                    ?>
                    <tr>
                        <td class="text-center" width="100px">
                            <a href="<?= $url ?>">
                                <?php if ($product->mainPhoto): ?>
                                    <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'list') ?>"
                                         alt="" class="img-thumbnail"/>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="text-left">
                            <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                        </td>
                        <td class="text-right" width="80px"><?= $item->getQuantity() ?> <small><?= Lang::t('шт') ?></small></td>
                        <td class="text-right" width="120px"><?= CurrencyHelper::get($item->getPrice(), false) ?></td>
                        <td class="text-center" width="10px">
                            <a type="button" href="<?= Url::to(['/shop/cart/remove', 'id' => $item->getId()]) ?>"
                                    data-method="post" title="Remove" class=""><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            </div>
            <div class=" px-2 d-flex">
                <div class="ml-auto">
                    <?= BtnToCart::widget(['url' => Url::to(['/shop/cart/index'])]) ?>
                </div>
            </div>
        </div>
    </li>
<?php endif; ?>
