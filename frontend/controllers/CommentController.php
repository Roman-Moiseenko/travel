<?php


namespace frontend\controllers;


use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    public $layout = 'main_ajax';


    public function actionNewComment()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['user'])) {
                //Получаем данные пользователя

            }

            return $this->render('new_comment', []);
            //return $params['text'];
        } else {
            throw new NotFoundHttpException('');
        }
    }

    public function actionCheckLogin()
    {

    }
}