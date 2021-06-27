<?php


namespace office\controllers\guides;


use booking\entities\booking\Meals;
use booking\entities\booking\trips\Type;
use booking\entities\Rbac;
use booking\forms\office\guides\MealTypeForm;
use booking\forms\office\guides\TripTypeForm;
use booking\services\office\guides\TypeMealService;
use booking\services\office\guides\TypeTripService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MealTypeController extends Controller
{

    /**
     * @var TypeMealService
     */
    private $service;

    public function __construct($id, $module, TypeMealService $service, $config = [])
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
        $types = Meals::find()->orderBy(['sort' => SORT_ASC])->all();
        return $this->render('index', [
            'types' => $types,
        ]);
    }

    public function actionCreate()
    {
        $form = new MealTypeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/meal-type/index']);
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
        $form = new MealTypeForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/meal-type/index']);
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
        if (!$result = Meals::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}