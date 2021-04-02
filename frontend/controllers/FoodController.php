<?php


namespace frontend\controllers;


use booking\entities\foods\Food;
use booking\entities\foods\InfoAddress;
use booking\forms\foods\ReviewFoodForm;
use booking\forms\foods\SearchFoodForm;
use booking\helpers\scr;
use booking\repositories\foods\FoodRepository;
use booking\services\foods\FoodService;
use frontend\widgets\reviews\NewReviewFoodWidget;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FoodController extends Controller
{
    public $layout = 'foods';
    /**
     * @var FoodRepository
     */
    private $foods;
    /**
     * @var FoodService
     */
    private $service;

    public function __construct($id, $module, FoodRepository $foods, FoodService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->foods = $foods;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SearchFoodForm([]);
        if (isset(\Yii::$app->request->queryParams['SearchFoodForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->foods->search($form);
        } else {
            $dataProvider = $this->foods->search();
        }
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $food = $this->findModel($id);

        if (!$food->isVisible()) {
            \Yii::$app->session->setFlash('error', 'Заведение не активно, доступ к информации ограничен!');
            return $this->goHome();
        }

        $form = new ReviewFoodForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addReview($food->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('food', [
            'food' => $food,
            'model' => $form,
        ]);
    }

    public function actionMapFoods()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $city = isset($params['city']) ? urldecode($params['city']) : '';
                $foods = $this->foods->getMap($params['kitchen_id'] ?? null, $params['category_id'] ?? null, $city);
                return json_encode($foods);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        } else {
            return $this->goHome();
        }
    }

    private function findModel($id)
    {
        if (($model = Food::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}