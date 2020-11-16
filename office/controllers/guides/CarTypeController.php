<?php


namespace office\controllers\guides;


use booking\entities\booking\cars\Characteristic;
use booking\entities\booking\cars\Type;
use booking\entities\Rbac;
use booking\forms\booking\cars\CharacteristicForm;
use booking\forms\office\guides\CarTypeForm;
use booking\services\office\guides\TypeCarService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CarTypeController extends Controller
{

    private $service;

    public function __construct($id, $module, TypeCarService $service, $config = [])
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
        $types = Type::find()->orderBy(['sort' => SORT_ASC])->all();
        return $this->render('index', [
            'types' => $types,
        ]);
    }

    public function actionView($id)
    {
        $type = $this->find($id);
        return $this->render('view', [
            'type' => $type,
        ]);
    }

    public function actionCreate()
    {
        $form = new CarTypeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/car-type/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionAddCharacteristic($id)
    {
        $type = $this->find($id);
        $form = new CharacteristicForm($type->id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addCharacteristic($id, $form);
                return $this->redirect(['guides/car-type/view', 'id' => $type->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('add-characteristic', [
            'model' => $form,
            'type' => $type,
        ]);
    }

    public function actionUpdateCharacteristic($id)
    {
        $characteristic = Characteristic::findOne($id);
        $form = new CharacteristicForm($characteristic->type_car_id, $characteristic);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateCharacteristic($characteristic->type_car_id, $characteristic->id, $form);
                return $this->redirect(['guides/car-type/view', 'id' => $characteristic->type_car_id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-characteristic', [
            'model' => $form,
            'characteristic' => $characteristic,
        ]);
    }

    public function actionDeleteCharacteristic($id)
    {
        $characteristic = Characteristic::findOne($id);
        $this->service->removeCharacteristic($characteristic->type_car_id, $characteristic->id);
        return $this->redirect(['guides/car-type/view', 'id' => $characteristic->type_car_id]);
    }

    public function actionUpdate($id)
    {
        $type = $this->find($id);
        $form = new CarTypeForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/car-type/index']);
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

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }

    private function find($id)
    {
        if (!$result = Type::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}