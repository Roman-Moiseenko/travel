<?php


namespace frontend\controllers\moving;


use booking\entities\Lang;
use booking\repositories\moving\PageRepository;
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

    public function __construct($id, $module, PageRepository $pages,  $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
    }

    public function actionIndex()
    {
        $this->layout = 'main_moving';
        $categories = $this->pages->findRoot();
        return $this->redirect(Url::to(['/moving/moving/view', 'slug' => $categories[0]->slug]));
        //return $this->render('index', ['categories' => $categories]);
    }


    public function actionView($slug)
    {
        //  scr::p($slug);
        $this->layout = 'main_moving';
        if (!$page = $this->pages->findBySlug($slug)) {
            \Yii::$app->session->setFlash('error', 'Страница не найдена');
            return $this->render(Url::to(['/about']));
        }
        $root = $this->pages->findRoot();
        //TODO Получаем список под папок
        $categories = $page->getChildren()->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
            'main_page' => $root[0]->slug == $slug
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