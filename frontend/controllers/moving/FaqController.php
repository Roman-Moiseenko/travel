<?php


namespace frontend\controllers\moving;

use booking\forms\moving\AnswerForm;
use booking\forms\moving\QuestionForm;
use booking\repositories\moving\CategoryFAQRepository;
use booking\repositories\moving\FAQRepository;
use booking\services\moving\FAQService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class FaqController extends Controller
{

    public $layout = 'main_moving';
    /**
     * @var CategoryFAQRepository
     */
    private $repository;
    /**
     * @var FAQRepository
     */
    private $FAQRepository;
    /**
     * @var FAQService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        CategoryFAQRepository $repository,
        FAQRepository $FAQRepository,
        FAQService $service,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->FAQRepository = $FAQRepository;
        $this->service = $service;
        $this->loginService = $loginService;
    }

    public function actionIndex()
    {
        $categories = $this->repository->getAll();
        return $this->render('index', [
            'categories' => $categories,
            'user' => $this->loginService->user(),
        ]);
    }

    public function actionCategory($id)
    {
        $category = $this->repository->get($id);
        $dataProvider = $this->FAQRepository->SearchModel($category->id);
        $model_answer = new AnswerForm();
        $form = new QuestionForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->question($category->id, $form);
                return $this->redirect(Url::to(['moving/faq/category', 'id' => $category->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'model' => $form,
            'model_answer' => $model_answer,
            'user' => $this->loginService->user(),
        ]);


    }

    public function actionAnswer($id)
    {
        $question = $this->FAQRepository->get($id);

        $form = new AnswerForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->answer($question->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}