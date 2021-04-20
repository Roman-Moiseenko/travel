<?php

namespace frontend\bootstrap;

use booking\entities\shops\cart\Cart;
use booking\entities\shops\cart\cost\calculator\DynamicCost;
use booking\entities\cart\shops\cost\calculator\SimpleCost;
use booking\entities\shops\cart\storage\HybridStorage;
use yii\base\Application;
use yii\base\BootstrapInterface;


class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                // new CookieStorage('cart', 3600*24*30),
                new SimpleCost()
            );
        });
    }
}