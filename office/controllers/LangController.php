<?php


namespace office\controllers;


use booking\entities\Rbac;
use office\forms\LangSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class LangController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        //TODO
    }
}