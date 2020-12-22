<?php


namespace office\controllers;


use booking\entities\mailing\Mailing;
use booking\entities\Rbac;
use booking\forms\MailingForm;
use booking\services\mailing\MailingService;
use office\forms\MailingSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MailingController extends Controller
{

    /**
     * @var MailingService
     */
    private $service;

    public function __construct($id, $module, MailingService $service, $config = [])
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
        $searchModel = new MailingSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new MailingForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $mailing = $this->service->create($form);
                return $this->redirect(['view', 'id' => $mailing->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $mailing = $this->findModel($id);
        if ($mailing->isSend()) {
            \Yii::$app->session->setFlash('error', 'Нельзя удалить отправленную рассылку');
        } else {
            $this->service->remove($mailing->id);
        }
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'mailing' => $this->findModel($id),
        ]);
    }
    public function actionUpdate($id)
    {
        $mailing = $this->findModel($id);
        if ($mailing->isSend()) {
            \Yii::$app->session->setFlash('warning', 'Нельзя удалить отправленную рассылку');
            return $this->redirect(['index']);
        }
        $form = new MailingForm($mailing);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($mailing->id, $form);
                return $this->redirect(['view', 'id' => $mailing->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionSend($id)
    {
        $this->service->send($id);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Mailing::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}