<?php


namespace admin\controllers\cabinet;


use admin\forms\user\LegalSearch;
use booking\entities\admin\user\User;
use booking\forms\auth\UserLegalForm;
use booking\services\admin\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class LegalController extends Controller
{
    public $layout = 'main-cabinet';
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
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

        $searchModel = new LegalSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    public function actionCreate()
    {
        $user = $this->findModel();

        $form = new UserLegalForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $legal = $this->service->newLegal($user->id, $form);
                return $this->redirect(['/cabinet/legal/view', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'user' => $user,
            'model' => $form,
        ]);

    }

    public function actionUpdate($id)
    {
        $user = $this->findModel();
        $legal = $user->getLegal($id);
        $form = new UserLegalForm($legal);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editLegal($user->id, $legal->id, $form);
                return $this->redirect(['/cabinet/legal/view', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'user' => $user,
            'model' => $form,
        ]);

    }

    public function actionView($id)
    {
        $user = $this->findModel();
        $legal = $user->getLegal($id);
        return $this->render('view', [
            'legal' => $legal,
        ]);

    }
    public function actionDelete($id)
    {
        $user = $this->findModel();
        $this->service->removeLegal($user->id, $id);
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}