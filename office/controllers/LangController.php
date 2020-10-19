<?php


namespace office\controllers;


use booking\entities\Rbac;
use booking\forms\LangForm;
use booking\helpers\scr;
use booking\services\LangService;
use office\forms\LangSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class LangController extends Controller
{

    /**
     * @var LangService
     */
    private $service;

    public function __construct($id, $module, LangService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

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
        $form = new LangForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->save($form);
                $form = new LangForm();
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        scr::p($id);
    }
}