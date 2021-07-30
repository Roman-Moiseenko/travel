<?php


namespace frontend\controllers\moving;


use booking\entities\Lang;
use booking\entities\moving\ReviewMoving;
use booking\forms\booking\ReviewForm;
use booking\forms\moving\ReviewMovingForm;
use booking\repositories\moving\PageRepository;
use booking\services\moving\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MovingController extends Controller
{
    public $layout = 'main_moving_landing';
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
        $this->layout = 'main_moving';
        $categories = $this->pages->findRoot();
        return $this->redirect(Url::to(['/moving/moving/view', 'slug' => $categories[0]->slug]));
    }


    public function actionView($slug)
    {

        $this->layout = 'main_moving';
        if (!$page = $this->pages->findBySlug($slug)) {
            \Yii::$app->session->setFlash('error', 'Страница не найдена');
            return $this->render(Url::to(['/about']));
        }
        $reviewForm = new ReviewMovingForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($page->id, $this->loginService->user()->id, $reviewForm);
                \Yii::$app->session->setFlash('success', Lang::t('Спасибо за оставленный комментарий на статью'));
                $reviewForm = new ReviewForm();

                //return $this->redirect(['tour/view', 'id' => $tour->id]);
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

    public function actionGetItems()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $page_id = $params['page_id'];
                $item_id = $params['item_id'];
                $items = $this->pages->getItemsMap($page_id, $item_id);
                return json_encode($items);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }
}