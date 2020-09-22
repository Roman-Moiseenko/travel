<?php


namespace admin\controllers\cabinet;


use admin\forms\user\LegalSearch;
use booking\entities\admin\ContactAssignment;
use booking\entities\admin\User;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\admin\UserLegalForm;
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
                return $this->redirect(['/cabinet/legal/view', 'id' => $legal->id]);
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
                return $this->redirect(['/cabinet/legal/view', 'id' => $legal->id]);
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
        return $this->redirect(['/cabinet/legal']);
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
                return $this->redirect(['/cabinet/legal/contacts', 'id' => $legal->id]);
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

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}