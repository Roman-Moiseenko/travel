<?php


namespace frontend\controllers\realtor;


use booking\helpers\scr;
use booking\helpers\StatusHelper;
use booking\repositories\realtor\PageRepository;
use booking\services\realtor\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class PageController extends Controller
{
    public $layout = 'main_land';
    /**
     * @var PageRepository
     */
    private $pages;
    /**
     * @var PageManageService
     */

    public function __construct(
        $id,
        $module,
        PageRepository $pages,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
    }

    public function actionIndex()
    {
        $page = $this->pages->findBySlug('info');
        //if ($page == null) return $this->redirect(\Yii::$app->request->referrer);
        $categories = $page->getChildren()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();

        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => true,
        ]);
    }

    public function actionView($slug)
    {
        try {
            $page = $this->pages->findBySlug($slug);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to(['/about']));
        }
        //$root = $this->pages->findRoot();
        $categories = $page->getChildren()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => false,
        ]);
    }

    public function actionModal()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $this->layout = 'main_ajax';
                $params = \Yii::$app->request->bodyParams;
                $modal_id = $params['modal_id'];
                //Получаем окно, тексты и картинки по $modal_id

                return $this->render('modal', [
                    'modal_id' => $modal_id,
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }
}