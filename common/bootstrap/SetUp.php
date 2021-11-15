<?php

namespace common\bootstrap;

use booking\entities\Lang;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\trips\TripRepository;
use booking\repositories\forum\SectionRepository;
use booking\repositories\office\PageRepository;
use booking\repositories\realtor\LandownerRepository;
use booking\repositories\touristic\fun\CategoryRepository;
use booking\repositories\touristic\fun\FunRepository;
use booking\services\RoleManager;
use booking\services\ContactService;
use booking\services\pdf\pdfServiceController;
use booking\services\system\LoginService;
use booking\services\yandex\Info;
use booking\services\yandex\YandexMarket;
use frontend\urls\CarTypeUrlRule;
use frontend\urls\ForumUrlRule;
use frontend\urls\FunTypeUrlRule;
use frontend\urls\FunUrlRule;
use frontend\urls\LandownerUrlRule;
use frontend\urls\MedicinePageUrlRule;
use frontend\urls\MovingPageUrlRule;
use frontend\urls\NightPageUrlRule;
use frontend\urls\PageUrlRule;
use frontend\urls\StayCategoryUrlRule;
use frontend\urls\TourTypeUrlRule;
use frontend\urls\TourUrlRule;
use frontend\urls\TripTypeUrlRule;
use frontend\urls\TripUrlRule;
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
                $app->mailer,
                new pdfServiceController('pdf_controller', new Module('pdf_module')),
                new LoginService()
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

        $container->setSingleton(LandownerUrlRule::class, [], [
            Instance::of(LandownerRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(MovingPageUrlRule::class, [], [
            Instance::of(\booking\repositories\moving\PageRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(NightPageUrlRule::class, [], [
            Instance::of(\booking\repositories\night\PageRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(MedicinePageUrlRule::class, [], [
            Instance::of(\booking\repositories\medicine\PageRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(TourTypeUrlRule::class, [], [
            Instance::of(\booking\repositories\booking\tours\TypeRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(TripTypeUrlRule::class, [], [
            Instance::of(\booking\repositories\booking\trips\TypeRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(CarTypeUrlRule::class, [], [
            Instance::of(\booking\repositories\booking\cars\TypeRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(FunTypeUrlRule::class, [], [
            Instance::of(\booking\repositories\touristic\fun\CategoryRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(StayCategoryUrlRule::class, [], [
            Instance::of(\booking\repositories\touristic\stay\CategoryRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(FunUrlRule::class, [], [
            Instance::of(FunRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(TourUrlRule::class, [], [
            Instance::of(TourRepository::class),
            Instance::of('cache'),
        ]);

        $container->setSingleton(TripUrlRule::class, [], [
            Instance::of(TripRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(ForumUrlRule::class, [], [
            Instance::of(SectionRepository::class),
            Instance::of('cache'),
        ]);




        if (!\Yii::$app->request->cookies->get('lang')) {
            //scr::v(\Yii::$app->language);
            if (!$data =\Yii::$app->geo->getData()) {
                $lang = Lang::DEFAULT;
            } else {
                $lang = strtolower($data['country']);
            }
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'lang',
                'value' => $lang,
                'expire' => time() + 3600 * 24 * 365
            ]));
        }
        $container->setSingleton(YandexMarket::class, [], [
            new Info($app->name, $app->name, $app->params['frontendHostInfo']),
        ]);
    }
}