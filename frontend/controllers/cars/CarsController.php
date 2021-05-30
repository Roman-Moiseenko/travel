<?php


namespace frontend\controllers\cars;


use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\ReviewForm;
use booking\helpers\scr;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\cars\TypeRepository;
use booking\services\booking\cars\CarService;
use booking\services\system\LoginService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CarsController extends Controller
{
    public $layout = 'cars';
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var TypeRepository
     */
    private $categories;
    /**
     * @var CarService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        CarRepository $cars,
        TypeRepository $categories,
        CarService $service,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cars = $cars;
        $this->categories = $categories;
        $this->service = $service;
        $this->loginService = $loginService;
    }

    public function actionIndex()
    {
        $form = new SearchCarForm([]);
        if (isset(\Yii::$app->request->queryParams['SearchCarForm'])) {
            if (isset(\Yii::$app->request->queryParams['SearchCarForm']['type'])) {
                $form->type = \Yii::$app->request->queryParams['SearchCarForm']['type'];
                $form->setAttribute($form->type);
            }
            $form->load(\Yii::$app->request->get());
            $dataProvider = $this->cars->search($form);
        } else {
            $dataProvider = $this->cars->search();
        }
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCar($id)
    {
        $this->layout = 'cars_blank';

        $car = $this->findModel($id);
        if ($car->isLock()) {
            \Yii::$app->session->setFlash('warning', Lang::t('Данное транспортное средство заблокировано! Доступ к нему ограничен.'));
            return $this->goHome();
        }
        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($car->id, $this->loginService->user()->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный отзыв'));
                return $this->redirect(['car/view', 'id' => $car->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $this->service->upViews($car);//Перед показом увеличиваем счетчик
        return $this->render('car', [
            'car' => $car,
            'reviewForm' => $reviewForm,
        ]);
    }

    public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException(Lang::t('Запрашиваемая категория не существует') . '.');
        }
        $form = new SearchCarForm(['type' => $category->id]);
        $form->setAttribute($category->id);
        if (isset(\Yii::$app->request->queryParams['SearchCarForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->cars->search($form);
        } else {
            $dataProvider = $this->cars->search($form);
        }
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetSearch()
    {
        $this->layout = '_blank';
        if (\Yii::$app->request->isAjax) {
            $form = new SearchCarForm();
            $form->date_from = \Yii::$app->request->bodyParams['date_from'];
            $form->date_to = \Yii::$app->request->bodyParams['date_to'];
            $form->city = \Yii::$app->request->bodyParams['city'];
            if (isset(\Yii::$app->request->bodyParams['type'])) {
                $form->type = \Yii::$app->request->bodyParams['type'];
                $form->setAttribute(\Yii::$app->request->bodyParams['type']);
            }
            return $this->render('_search', [
                'model' => $form,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}