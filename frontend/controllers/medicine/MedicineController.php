<?php


namespace frontend\controllers\medicine;


use booking\entities\Lang;
use booking\forms\CommentForm;
use booking\helpers\StatusHelper;
use booking\repositories\medicine\PageRepository;
use booking\services\medicine\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class MedicineController extends Controller
{
    public $layout = 'main';//_medicine';
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
        $page = $this->pages->findBySlug($categories[0]->slug);
        $categories = $page->getChildren()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => true,
            'reviewForm' => null,
        ]);
        //return $this->redirect(Url::to(['/medicine/medicine/view', 'slug' => $categories[0]->slug]));
    }


    public function actionView($slug)
    {
        try {
            $page = $this->pages->findBySlug($slug);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to(['/about']));
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
        $categories = $page->getChildren()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => $root[0]->slug == $slug,
            'reviewForm' => $reviewForm,
        ]);
    }
}