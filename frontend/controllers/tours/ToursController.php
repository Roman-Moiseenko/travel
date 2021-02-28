<?php


namespace frontend\controllers\tours;

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\scr;

use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\services\booking\tours\TourService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ToursController extends Controller
{
    public $layout = 'tours';
    private $tours;
    private $service;
    /**
     * @var TypeRepository
     */
    private $categories;

    public function __construct($id, $module, TourRepository $tours, TypeRepository $categories, TourService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tours = $tours;
        $this->service = $service;
        $this->categories = $categories;
    }

    public function actionIndex()
    {
        $form = new SearchTourForm([]);
        if (isset(\Yii::$app->request->queryParams['SearchTourForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->tours->search($form);
        } else {
            $dataProvider = $this->tours->search();
        }

        return $this->render('index_top', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTour($slug)
    {
        $this->layout = 'tours_blank';

        $tour = $this->tours->findBySlug($slug);
        if ($tour->isLock()) {
            \Yii::$app->session->setFlash('warning', Lang::t('Данная экскурсия заблокирована! Доступ к ней ограничен.'));
            return $this->goHome();
        }
        $reviewForm = new ReviewForm();
        //scr::p($reviewForm);
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($tour->id, \Yii::$app->user->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный отзыв'));
                return $this->redirect(['tour/view', 'id' => $tour->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $this->service->upViews($tour);//Перед показом увеличиваем счетчик
        return $this->render('tour', [
            'tour' => $tour,
            'reviewForm' => $reviewForm,
        ]);
    }

   public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException(Lang::t('Запрашиваемая категория не существует') . '.');
        }
        $form = new SearchTourForm(['type' => $category->id]);
        if (isset(\Yii::$app->request->queryParams['SearchTourForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->tours->search($form);
        } else {
            $dataProvider = $this->tours->search($form);
        }
        //return $this->redirect();
        return $this->render('index_top', [
            'model' => $form,
            'dataProvider' => $dataProvider,
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