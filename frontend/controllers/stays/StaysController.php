<?php


namespace frontend\controllers\stays;


use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\CurrencyHelper;
use booking\helpers\scr;
use booking\helpers\stays\StayHelper;
use booking\repositories\booking\stays\StayRepository;
use booking\services\booking\stays\StayService;
use yii\web\Controller;

class StaysController extends Controller
{
    public $layout = 'stays';
    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var StayService
     */
    private $service;

    public function __construct(
        $id,
        $module,
        StayRepository $stays,
        StayService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->stays = $stays;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SearchStayForm();
        if (isset(\Yii::$app->request->queryParams['SearchStayForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->stays->search($form);
        } else {
            $dataProvider = $this->stays->search();
        }
        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionStay($id)
    {
        $this->layout = 'stays_blank';
        $form = new SearchStayForm();
        $stay = $this->stays->get($id);
        $params = \Yii::$app->request->queryParams;
        if (!isset($params['SearchStayForm'])) {
            $params['SearchStayForm'] = [
                'date_from' => '',
                'date_to' => '',
                'guest' => 1,
                'children' => 0,
                'children_age' => [1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '',],
            ];

        }
        $form->load($params);
        if ($stay->isLock()) {
            \Yii::$app->session->setFlash('warning', Lang::t('Жилье заблокировано! Доступ к нему ограничен.'));
            return $this->goHome();
        }
        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($stay->id, \Yii::$app->user->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный отзыв'));
                return $this->redirect(['stay/view', 'id' => $stay->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $this->service->upViews($stay);//Перед показом увеличиваем счетчик
        return $this->render('stay', [
            'stay' => $stay,
            'SearchStayForm' => $params['SearchStayForm'],
            'reviewForm' => $reviewForm,
            'model' => $form,
        ]);
    }

    public function actionGetBooking()
    {
        if (\Yii::$app->request->isAjax)
        {
            try {
                $params = \Yii::$app->request->bodyParams;
                $stay = $this->stays->get($params['stay_id']);
                //Проверяем наличие мест на новые даты и кол-во гостей

                //Вычисляем новую стоимость от параметров и выбранных услуг
                $cost = StayHelper::getCostByParams($stay, $params);
                return $cost;//CurrencyHelper::stat($cost);
                //TODO ==>
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return 'Error page!';
    }



}