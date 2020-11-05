<?php


namespace console\controllers;

use booking\services\mailing\MailingService;
use yii\console\Controller;

class MailingController extends Controller
{
    private $service;
    public function __construct($id, $module,
                                MailingService $service,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionTours()
    {
        $mailing = $this->service->createTours();
        if ($mailing) $this->service->send($mailing->id);
    }

    public function actionStays()
    {
        $mailing = $this->service->createStays();
        if ($mailing) $this->service->send($mailing->id);
    }

    public function actionCars()
    {
        $mailing = $this->service->createCars();
        if ($mailing) $this->service->send($mailing->id);
    }

    public function actionFuns()
    {
        $mailing = $this->service->createFuns();
        if ($mailing) $this->service->send($mailing->id);
    }

    public function actionBlog()
    {
        $mailing = $this->service->createBlog();
        if ($mailing) $this->service->send($mailing->id);
    }

    public function actionPromotions()
    {
        //TODO Заглушка Promotion
    }
}