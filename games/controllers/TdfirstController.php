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
        $params = \Yii::$app->request->post();
        $result = $this->service->getJSON($params['user_id']);
        return $result;
    }
}