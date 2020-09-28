<?php


namespace office\controllers\guides;


use booking\entities\booking\tours\Type;
use booking\entities\Rbac;
use booking\forms\office\guides\TourTypeForm;
use booking\services\booking\tours\TypeService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TourTypeController extends Controller
{

    /**
     * @var TypeService
     */
    private $service;

    public function __construct($id, $module, TypeService $service, $config = [])
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

    public function actionCreate()
    {
        $form = new TourTypeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/tour-type/view']);
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

    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
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
        if (!$result = '')
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}