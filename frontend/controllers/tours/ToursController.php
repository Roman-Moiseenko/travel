<?php


namespace frontend\controllers\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\tours\SearchToursForm;
use booking\helpers\scr;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ToursController extends Controller
{
    public $layout = 'tours';
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var TourService
     */
    private $service;

    public function __construct($id, $module, TourRepository $tours, TourService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tours = $tours;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SearchToursForm();
        if (isset(\Yii::$app->request->queryParams['SearchToursForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->tours->search($form);
        } else {
            $dataProvider = $this->tours->search();
        }
        //return $this->redirect();
        return $this->render('index_top', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTour($id)
    {
        $this->layout = 'tours_blank';

        $tour = $this->findModel($id);
        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($id, \Yii::$app->user->id, $reviewForm);
                \Yii::$app->session->setFlash('success', 'Ваш отзыв был отправлен на модерацию. В ближащее время мы его опубликуем. Спасибо!');
                return $this->redirect(['tours/view', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('tour', [
            'tour' => $tour,
            'reviewForm' => $reviewForm,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }



}