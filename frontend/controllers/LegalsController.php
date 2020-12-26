<?php


namespace frontend\controllers;


use booking\entities\admin\Legal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LegalsController extends Controller
{
    public $layout = 'blank';

    public function actionIndex()
    {

    }

    public function actionView($id)
    {
        $legal = $this->findModel($id);
        if ($legal->user->isLock()) {
            \Yii::$app->session->setFlash('error', 'Провайдер не активен, доступ к информации ограничен!');
            return $this->goHome();
        }
        return $this->render('legal', [
            'legal' => $legal,
        ]);
    }

    private function findModel($id)
    {
        if (($model = Legal::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}