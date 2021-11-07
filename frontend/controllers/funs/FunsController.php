<?php


namespace frontend\controllers\funs;


use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use booking\forms\booking\funs\SearchFunForm;
use booking\forms\booking\ReviewForm;
use booking\helpers\scr;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\funs\TypeRepository;
use booking\repositories\touristic\fun\CategoryRepository;
use booking\services\booking\funs\FunService;
use booking\services\system\LoginService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FunsController extends Controller
{
    public $layout = 'funs';
    /**
     * @var FunRepository
     */
    private $funs;
    /**
     * @var CategoryRepository
     */
    private $categories;
    /**
     * @var FunService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        FunRepository $funs,
        //TypeRepository $categories,
        FunService $service,
        LoginService $loginService,
        CategoryRepository $categories,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->funs = $funs;
        $this->categories = $categories;
        $this->service = $service;
        $this->loginService = $loginService;
    }

    public function actionIndex()
    {
        /*$form = new SearchFunForm([]);
        if (isset(\Yii::$app->request->queryParams['SearchFunForm'])) {
            if (isset(\Yii::$app->request->queryParams['SearchFunForm']['type'])) {
                $form->type = \Yii::$app->request->queryParams['SearchFunForm']['type'];
                $form->setAttribute($form->type);
            }
            $form->load(\Yii::$app->request->get());
            $dataProvider = $this->funs->search($form);
        } else {
            $dataProvider = $this->funs->search();
        }*/
        $categories = $this->categories->getAll();
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionFun($slug)
    {
        $this->layout = 'booking_blank';

        $fun = $this->funs->findBySlug($slug);
       /* if ($fun->isLock()) {
            \Yii::$app->session->setFlash('warning', Lang::t('Данное развлечение заблокировано! Доступ к нему ограничен.'));
            return $this->goHome();
        }*/
        $reviewForm = new ReviewForm();
        //scr::p(\Yii::$app->request->post());
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($fun->id, $this->loginService->user()->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный отзыв'));
                return $this->redirect(['fun/view', 'id' => $fun->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('fun', [
            'fun' => $fun,
            'reviewForm' => $reviewForm,
        ]);
    }

    public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException(Lang::t('Запрашиваемая категория не существует') . '.');
        }
        //$form = new SearchFunForm(['type' => $category->id]);
        //$funs = $this->funs->get
        /*$form->setAttribute($category->id);
        if (isset(\Yii::$app->request->queryParams['SearchCarForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->funs->search($form);
        } else {
            $dataProvider = $this->funs->search($form);
        } */
        return $this->render('category', [
            'category' => $category,
            //'model' => $form,
            'dataProvider' => null,//$dataProvider,
        ]);
    }

    public function actionGetSearch()
    {
        $this->layout = '_blank';
        if (\Yii::$app->request->isAjax) {
            $form = new SearchFunForm();
            $form->date_from = \Yii::$app->request->bodyParams['date_from'];
            $form->date_to = \Yii::$app->request->bodyParams['date_to'];
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
        if (($model = Fun::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}