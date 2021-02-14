<?php


namespace admin\controllers\tour;


use admin\forms\StackSearch;
use booking\entities\admin\Legal;
use booking\entities\booking\tours\stack\Stack;
use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\StackTourForm;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\StackService;
use yii\filters\AccessControl;
use yii\web\Controller;
use function Symfony\Component\String\s;

class StackController extends Controller
{
    public $layout ='main';
    /**
     * @var StackService
     */
    private $service;
    /**
     * @var TourRepository
     */
    private $tours;

    public function __construct($id, $module, StackService $service, TourRepository $tours, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->tours = $tours;
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
        $searchModel = new StackSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $form = new StackTourForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $stack = $this->service->create($form);
                return $this->redirect(['tour/stack/view', 'id' => $stack->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                \Yii::$app->errorHandler->logException($e);
            }

        }
        return $this->render('create', [
            'model' => $form
        ]);
    }
    public function actionUpdate($id)
    {
        $stack = $this->find($id);

        $form = new StackTourForm($stack);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($stack->id, $form);
                return $this->redirect(['tour/stack/view', 'id' => $stack->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                \Yii::$app->errorHandler->logException($e);
            }
        }
        return $this->render('update', [
            'model' => $form,
            'stack' => $stack,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['tour/stack']);
    }

    public function actionView($id)
    {
        $stack = $this->find($id);

        return $this->render('view', [
            'stack' => $stack,
        ]);
    }

    public function actionAssign($id)
    {
        $stack = $this->find($id);
        $tours = Tour::find()->active()->andWhere(['legal_id' => $stack->legal_id])->andWhere(['params_private' => true])->all();;
        return $this->render('assign', [
            'stack' => $stack,
            'tours' => $tours,
        ]);
    }

    public function actionSetStack()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            try {
                $this->service->setAssign($params['stack_id'], $params['tour_id'], $params['set']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                return $e->getMessage();
            }
        }
    }

    public function find($id)
    {

        if (!$result = Stack::findOne($id)) {
            throw new \DomainException('Стек не найден ID=' . $id);
        }
        if ($result->legal->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного стека!');
        }
        return $result;
    }

}