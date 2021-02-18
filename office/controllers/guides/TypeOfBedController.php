<?php


namespace office\controllers\guides;


use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\entities\Rbac;
use booking\forms\office\guides\TypeOfBedForm;
use booking\services\office\guides\TypeOfBedService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TypeOfBedController extends Controller
{
    /**
     * @var TypeOfBedService
     */
    private $service;

    public function __construct($id, $module, TypeOfBedService $service, $config = [])
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
        $types = TypeOfBed::find()->orderBy(['name' => SORT_ASC])->all();
        return $this->render('index', [
            'types' => $types,
        ]);
    }

    public function actionCreate()
    {
        $form = new TypeOfBedForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/type-of-bed/index']);
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
        $type = $this->find($id);
        $form = new TypeOfBedForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/type-of-bed/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function find($id)
    {
        if (!$result = TypeOfBed::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}