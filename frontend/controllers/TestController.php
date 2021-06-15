<?php


namespace frontend\controllers;


use booking\helpers\scr;
use yii\web\Controller;

class TestController extends Controller
{
    public $layout = 'blank';
    public function actionIndex()
    {
        //$result = file_get_contents("https://www.instagram.com/kuda_dety39/");
        //$result = file_get_contents("https://www.instagram.com/p/CQAnCEHiWp0/");
        //$result2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . ‘/здесь_путь’);
        //scr::v($result);

        $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());

// For getting information about account you don't need to auth:

        /*try {
            $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'koenigs.ru', 'Foolprof03', null);
            $instagram->login();

            $account = $instagram->getAccount('koenigs.ru');
        } catch (\Throwable $e) {
            $account = null;
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }*/
        return $this->render('index', [
           // 'account' => $account,
        ]);
    }
}