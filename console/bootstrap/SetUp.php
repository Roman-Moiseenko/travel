<?php

namespace console\bootstrap;

use booking\entities\Lang;
use booking\helpers\scr;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\repositories\office\PageRepository;
use booking\services\RoleManager;
use booking\services\ContactService;
use booking\services\pdf\pdfServiceController;
use booking\services\system\LoginService;
use frontend\urls\PageUrlRule;
use frontend\urls\TourTypeUrlRule;
use frontend\urls\TourUrlRule;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\di\Instance;
use yii\web\Cookie;

class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(pdfServiceController::class, function () use ($app) {
            return new pdfServiceController('pdf_controller', new Module('pdf_module'));
        });

        $container->setSingleton(ContactService::class, function () use ($app) {
            return new ContactService(
                $app->mailer, new pdfServiceController('pdf_controller', new Module('pdf_module')), new LoginService()
            );
        });

        $container->setSingleton('cache', function () use ($app) {
            return $app->cache;
        });

    }
}