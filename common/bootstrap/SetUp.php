<?php

namespace common\bootstrap;

use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\repositories\office\PageRepository;
use booking\services\RoleManager;
use booking\services\ContactService;
use booking\services\pdf\pdfServiceController;
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

        $container->setSingleton(\booking\services\admin\PasswordResetService::class, function () use ($app) {

            return new \booking\services\admin\PasswordResetService(
                [ $app->params['supportEmail'] => $app->name . ' robot'],
                $app->mailer,
                new \booking\repositories\admin\UserRepository());
        });

        $container->setSingleton(\booking\services\user\PasswordResetService::class, function () use ($app) {

            return new \booking\services\user\PasswordResetService(
                [ $app->params['supportEmail'] => $app->name . ' robot'],
                $app->mailer,
                new \booking\repositories\user\UserRepository());
        });
        //
        $container->setSingleton(pdfServiceController::class, function () use ($app) {
            return new pdfServiceController('pdf_controller', new Module('pdf_module'));
        });

        $container->setSingleton(ContactService::class, function () use ($app) {
            return new ContactService(
                $app->mailer, new pdfServiceController('pdf_controller', new Module('pdf_module'))
            );
        });
        $container->setSingleton(RoleManager::class, function () use ($app) {
            return new RoleManager($app->get('authManager'));
        });
/*
        $container->setSingleton(SignupService::class, function () {
            return new SignupService();
        });
        */
        $container->setSingleton('cache', function () use ($app) {
            return $app->cache;
        });


        $container->setSingleton(PageUrlRule::class, [], [
            Instance::of(PageRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(TourTypeUrlRule::class, [], [
            Instance::of(TypeRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(TourUrlRule::class, [], [
            Instance::of(TourRepository::class),
            Instance::of('cache'),
        ]);
        if (!\Yii::$app->request->cookies->get('lang')) {
            if (!$data =\Yii::$app->geo->getData()) {
                $lang = 'ru';
            } else {
                $lang = $data['country'];
            }
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'lang',
                'value' => $lang,
                'expire' => time() + 3600 * 24 * 365
            ]));
        }
    }
}