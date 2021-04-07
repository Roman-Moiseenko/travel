<?php


namespace office\controllers\guides;


use booking\entities\Rbac;
use booking\entities\shops\products\Material;
use booking\forms\office\guides\MaterialForm;
use booking\services\office\guides\MaterialService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MaterialController extends Controller
{

    /**
     * @var MaterialService
     */
    private $service;

    public function __construct($id, $module, MaterialService $service, $config = [])
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
        $materials = Material::find()->all();
        return $this->render('index', [
            'materials' => $materials,
        ]);
    }

    public function actionCreate()
    {
        $form = new MaterialForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/material/index']);
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
        $material = $this->find($id);
        $form = new MaterialForm($material);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/material/index']);
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
        if (!$result = Material::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}