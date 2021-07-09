<?php


namespace frontend\controllers\trips;


use booking\entities\booking\trips\Trip;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\trips\SearchTripForm;
use booking\repositories\booking\trips\TripRepository;
use booking\repositories\booking\trips\TypeRepository;
use booking\services\booking\trips\TripService;
use booking\services\system\LoginService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class TripsController extends Controller
{
    public $layout = 'trips';

    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var TripRepository
     */
    private $trips;
    /**
     * @var TypeRepository
     */
    private $categories;
    /**
     * @var TripService
     */
    private $service;

    public function __construct(
        $id,
        $module,
        TripRepository $trips,
        TypeRepository $categories,
        TripService $service,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
        $this->trips = $trips;
        $this->categories = $categories;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SearchTripForm([]);
        if (isset(\Yii::$app->request->queryParams['SearchTripForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->trips->search($form);
        } else {
            $dataProvider = $this->trips->search();
        }
        \Yii::$app->response->headers->set('Cache-Control', 'public, max-age=' . 60 * 60 * 1);
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrip($slug)
    {
        $this->layout = 'booking_blank';

        $trip = $this->trips->findBySlug($slug);
        if ($trip->isLock()) {
            \Yii::$app->session->setFlash('warning', Lang::t('Тур заблокирован! Доступ к нему ограничен.'));
            return $this->goHome();
        }
        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($trip->id, $this->loginService->user()->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный отзыв'));
                return $this->redirect(['trip/view', 'id' => $trip->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $this->service->upViews($trip);//Перед показом увеличиваем счетчик
        \Yii::$app->response->headers->set('Cache-Control', 'public, max-age=' . 60 * 60 * 1);
        return $this->render('trip', [
            'trip' => $trip,
            'reviewForm' => $reviewForm,
        ]);
    }

   public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException(Lang::t('Запрашиваемая категория не существует') . '.');
        }
        $form = new SearchTripForm(['type' => $category->id]);
        if (isset(\Yii::$app->request->queryParams['SearchTripForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->trips->search($form);
        } else {
            $dataProvider = $this->trips->search($form);
        }
        //return $this->redirect();
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }



}