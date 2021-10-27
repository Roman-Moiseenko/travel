<?php


namespace games\controllers;


use engine\tdfirst\gUserService;
use yii\web\Controller;

class TdfirstController extends Controller
{
    /**
     * @var gUserService
     */
    private $service;

    public function __construct($id, $module, gUserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionLoad()
    {
        try {
            $params = \Yii::$app->request->post();
            $timestamp = $params['timestamp'];
            \Yii::error($timestamp);
            $result = $this->service->getJSON($params['user_id']);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return $e->getMessage();
        }
    }
}