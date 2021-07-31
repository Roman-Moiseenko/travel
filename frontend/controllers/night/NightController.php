<?php


namespace frontend\controllers\night;


use booking\entities\Lang;
use booking\forms\moving\ReviewMovingForm;
use booking\forms\CommentForm;
use booking\repositories\night\PageRepository;
use booking\services\night\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NightController extends Controller
{
    public $layout = 'main_night';
    /**
     * @var PageRepository
     */
    private $pages;
    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var PageManageService
     */
    private $service;

    public function __construct(
        $id,
        $module,
        PageRepository $pages,
        LoginService $loginService,
        PageManageService $service,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
        $this->loginService = $loginService;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $categories = $this->pages->findRoot();
        return $this->redirect(Url::to(['/night/night/view', 'slug' => $categories[0]->slug]));
    }


    public function actionView($slug)
    {
        if (!$page = $this->pages->findBySlug($slug)) {
            \Yii::$app->session->setFlash('error', 'Страница не найдена');
            return $this->render(Url::to(['/about']));
        }
        $reviewForm = new CommentForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($page->id, $this->loginService->user()->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный комментарий на статью'));
                $reviewForm = new CommentForm();
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $root = $this->pages->findRoot();
        $categories = $page->getChildren()->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => $root[0]->slug == $slug,
            'reviewForm' => $reviewForm,
        ]);
    }

}