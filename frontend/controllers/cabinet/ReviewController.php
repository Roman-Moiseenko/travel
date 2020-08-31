<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\ReviewTour;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\scr;
use booking\repositories\booking\ReviewRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;

class ReviewController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var ReviewRepository
     */
    private $reviews;
    /**
     * @var TourService
     */
    private $tours;

    public function __construct(
        $id,
        $module,
        ReviewRepository $reviews,
        TourService $tours,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->reviews = $reviews;
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
        $reviews = $this->reviews->getByUser(\Yii::$app->user->id);

        return $this->render('index', [
           'reviews' => $reviews,
        ]);
    }

    public function actionDeleteTour($id)
    {
        try {
            $this->tours->removeReview($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['cabinet/review/index']);
    }

    public function actionUpdateTour($id)
    {
        if (!$review = ReviewTour::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        $form = new ReviewForm($review);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->tours->editReview($id, $form);
                return $this->redirect(['cabinet/review/index']);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'review' => $review,
        ]);
    }

    //TODO  //**** На будущее *****///

    public function actionDeleteStay($id)
    {

     /*   try {
            $this->stays->removeReview($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['cabinet/review/index']);    */
    }

    public function actionUpdateStay($id)
    {
      /*  if (!$review = ReviewStay::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        $form = new ReviewForm($review);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->stays->editReview($id, $form);
                return $this->redirect(['cabinet/review/index']);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'review' => $review,
        ]);*/
    }

    public function actionDeleteCar($id)
    {
      /*  try {
            $this->cars->removeReview($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['cabinet/review/index']);*/
    }
    public function actionUpdateCar($id)
    {
       /* if (!$review = ReviewCar::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        $form = new ReviewForm($review);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->cars->editReview($id, $form);
                return $this->redirect(['cabinet/review/index']);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'review' => $review,
        ]);*/
    }

}