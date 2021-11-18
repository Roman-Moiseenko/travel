<?php


namespace frontend\controllers\art;


use booking\entities\Lang;
use booking\forms\moving\ReviewMovingForm;
use booking\forms\CommentForm;
use booking\helpers\StatusHelper;
use booking\repositories\moving\PageRepository;
use booking\services\moving\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class ArtController extends Controller
{
    public $layout = 'main_art';

    /**
     * @var LoginService
     */
    private $loginService;


    public function __construct(
        $id,
        $module,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
    }

    public function actionIndex()
    {
        if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));
        return $this->redirect(Url::to(['/art/events']));
    }


    public function actionView($slug)
    {
        if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));
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