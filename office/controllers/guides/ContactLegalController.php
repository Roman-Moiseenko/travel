<?php


namespace office\controllers\guides;


use booking\entities\admin\Contact;
use booking\entities\Rbac;
use booking\forms\office\guides\ContactLegalForm;
use booking\services\office\guides\ContactLegalService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ContactLegalController extends Controller
{
    private $service;

    public function __construct($id, $module, ContactLegalService $service, $config = [])
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
                        'roles' => [Rbac::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $contacts = Contact::find()->all();

        return $this->render('index', [
            'contacts' => $contacts,
        ]);
    }

    public function actionCreate()
    {
        $form = new ContactLegalForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/contact-legal/index']);
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
        $contact = $this->find($id);
        $form = new ContactLegalForm($contact);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/contact-legal/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'contact' => $contact,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    private function find($id)
    {
        if (!$result = Contact::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}