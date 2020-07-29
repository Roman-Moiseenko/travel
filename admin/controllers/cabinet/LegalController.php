<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\user\User;
use yii\filters\AccessControl;
use yii\web\Controller;

class LegalController extends Controller
{
    public $layout = 'main-cabinet';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        //   'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = $this->findModel();
        return $this->render('index', [
            'user' => $user,
        ]);
    }


    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}