<?php


namespace frontend\controllers\stays;


use booking\forms\booking\ReviewForm;

use booking\repositories\booking\stays\StayRepository;
use booking\repositories\touristic\stay\CategoryRepository;
use booking\services\booking\stays\StayService;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StaysController extends Controller
{
    public $layout = 'stays';
    /**
     * @var CategoryRepository
     */
    private $categories;

    public function __construct(
        $id,
        $module,

        //LoginService $loginService,
        CategoryRepository $categories,
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->categories = $categories;
    }

    public function actionIndex()
    {
        $categories = $this->categories->getAll();
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionNot($id)
    {
        throw new NotFoundHttpException();
    }

    public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException('Запрашиваемая категория не существует.');
        }
        //$dataProvider = $this->stays->getAllByCategory($category->id);
        return $this->render('category', [
            'category' => $category,

            //'dataProvider' => $dataProvider,
        ]);
    }
    /*
    public function actionIndex()
    {
        $form = new SearchStayForm();
        if (isset(\Yii::$app->request->queryParams['SearchStayForm']) &&
            $form->load(\Yii::$app->request->get()) &&
            $form->validate()) {
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
        $this->layout = 'booking_blank';
        $form = new SearchStayForm();
        $stay = $this->stays->get($id);
        $params = \Yii::$app->request->queryParams;
        $onMap = isset($params['map']) ? true : false;
        if ($onMap) {
            unset($_GET['map']);
        }
        if (!isset($params['SearchStayForm'])) {
            $params['SearchStayForm'] = [
                'date_from' => '',
                'date_to' => '',
                'guest' => 1,
                'children' => 0,
                'children_age' => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '',],
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
                $this->service->addReview($stay->id, $this->loginService->user()->getId(), $reviewForm);
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
            'openMap' => isset($params['map']) ? true : false,
        ]);
    }

    public function actionGetError()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['code_error'])) return Stay::listErrors()[$params['code_error']];
        }
        return null;
    }

    public function actionGetBooking()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $stay = $this->stays->get($params['stay_id']);
                $result = $stay->checkBySearchParams($params);
                $error = 0;
                if ($result !== true) $error = Stay::listErrors()[$result];
                //Вычисляем новую стоимость от параметров и выбранных услуг
                $cost = ($error === 0) ? $stay->costBySearchParams($params) : 0;
                return json_encode(
                    [
                        'error' => $error,
                        'cost' => CurrencyHelper::get($cost, false),
                        'prepay' => CurrencyHelper::get($cost * $stay->prepay / 100, false),
                        'percent' => $stay->prepay,
                    ]);

            } catch (\Throwable $e) {
                return json_encode(
                    [
                        'error' => $e->getMessage() . ' Отправьте пожалуйста снимок экрана нам на почту',
                        'cost' => 0,
                        'prepay' => 0,
                        'percent' => 0,
                    ]);

            }
        }
        return 'Error page!';
    }

    public function actionGetMaps()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                //По параметрам ищем все Stays
                $stays = $this->stays->findForMap($params);
                //Отправляем Фото(ссылка), Название, Цена за период/ Ссылка, description, координаты coords[], адрес?

                return json_encode($stays);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }

        }
        return 'Error';
    }
    */
}