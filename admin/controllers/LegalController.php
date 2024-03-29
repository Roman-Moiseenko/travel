<?php


namespace admin\controllers;


use admin\forms\user\LegalSearch;
use booking\entities\admin\Cert;
use booking\entities\admin\ContactAssignment;
use booking\entities\admin\User;
use booking\forms\admin\CertForm;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\admin\UserLegalForm;
use booking\helpers\scr;
use booking\services\admin\UserManageService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;

class LegalController extends Controller
{
    public $layout = 'main';
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->loginService = $loginService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new LegalSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $user = $this->findModel();
        $form = new UserLegalForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $legal = $this->service->newLegal($user->id, $form);
                return $this->redirect(['/legal/view', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
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
                return $this->redirect(['/legal/view', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'legal' => $legal,
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
        return $this->redirect(['/legal']);
    }

    public function actionContacts($id)
    {
        $user = $this->findModel();
        $legal = $user->getLegal($id);
        $form = new ContactAssignmentForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addLegalContact($legal->id, $form);
                return $this->redirect(\Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('contacts', [
            'legal' => $legal,
            'model' => $form,
        ]);
    }

    public function actionContactUpdate($id)
    {
        $user = $this->findModel();
        $contact = ContactAssignment::findOne($id);
        $legal = $user->getLegal($contact->legal_id);
        $form = new ContactAssignmentForm($contact);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateLegalContact($legal->id, $id, $form);
                return $this->redirect(['/legal/contacts', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('contact-update', [
            'legal' => $legal,
            'model' => $form,
        ]);
    }

    public function actionContactRemove($id)
    {
        $user = $this->findModel();
        $legal_id = ContactAssignment::find()->andWhere(['id' => $id])->select('legal_id');
        try {
            $this->service->removeLegalContact($legal_id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCerts($id)
    {
        $user = $this->findModel();
        $legal = $user->getLegal($id);
        $form = new CertForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addLegalCert($legal->id, $form);
                return $this->redirect(\Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->render('certs', [
            'legal' => $legal,
            'model' => $form,
        ]);
    }

    public function actionCertUpdate($id)
    {
        $user = $this->findModel();
        $cert = Cert::findOne($id);
        $legal = $user->getLegal($cert->legal_id);
        $form = new CertForm($cert);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateLegalCert($legal->id, $id, $form);
                return $this->redirect(['/legal/certs', 'id' => $legal->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('cert-update', [
            'legal' => $legal,
            'model' => $form,
            'cert' => $cert,
        ]);
    }

    public function actionCertRemove($id)
    {
        $cert = Cert::findOne($id);
        try {
            $this->service->removeLegalCert($cert->legal_id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel()
    {
        return $this->loginService->admin();
    }
}