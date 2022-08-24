<?php


namespace frontend\controllers;


use booking\entities\Lang;
use booking\repositories\CheckClickRepository;
use booking\services\CheckClickService;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * @var CheckClickService
     */
    private $clickService;

    public function __construct($id, $module, CheckClickService $clickService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->clickService = $clickService;
    }

    public function actionLangt()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return Lang::t($params['text']);
        }
    }

    public function actionLangcurrent()
    {
        if (\Yii::$app->request->isAjax) {
            return Lang::current();
        }
    }

    public function actionLoad()
    {
        $this->enableCsrfValidation = false;
        $params = \Yii::$app->request->post();
        \Yii::error($params);
        $filename = "data.txt"; //
        return \Yii::$app->request->getCsrfToken();
        //return file_put_contents($filename, $params, FILE_APPEND | LOCK_EX);

    }

    public function actionYoutube()
    {
        //TODO Переделать!!!!
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {

            $params = \Yii::$app->request->bodyParams;
            $url = $params['url_video'];
            return $this->render('youtube', ['url' => $url]);
        } else {
            return $this->goHome();
        }
    }

    public function actionGetWidget()
    {

        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            try {


                $params = \Yii::$app->request->bodyParams;
                $classWidget = $params['class_widget'];
                $result = $classWidget::widget();
                return $result;
            } catch (\Throwable $e) {
                return  $e->getMessage();
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionClickUser()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                return $this->clickService->create($params);
            } catch (\Throwable $e) {
                return  $e->getMessage();
            }
        } else {
            return $this->goHome();
        }
    }
}