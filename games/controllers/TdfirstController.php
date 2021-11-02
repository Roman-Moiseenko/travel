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

    public function actionLoadData()
    {
        try {
            $params = \Yii::$app->request->post();
            $result = $this->service->getData($params['user_id']);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_params';
        }
    }

    public function actionLoadSettings()
    {
        try {
            $params = \Yii::$app->request->post();
            $result = $this->service->getSettings($params['user_id']);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_params';
        }
    }

    public function actionSaveData()
    {
        try {
            $params = \Yii::$app->request->post();
            $result = $this->service->setData($params['user_id'], $params['data_json']);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_params' . $e->getMessage();
        }
    }

    public function actionSaveSettings()
    {
        try {
            $params = \Yii::$app->request->post();
            $result = $this->service->setData($params['user_id'], $params['settings_json']);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_params' . $e->getMessage();
        }
    }
}