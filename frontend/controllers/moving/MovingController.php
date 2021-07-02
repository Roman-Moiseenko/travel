<?php


namespace frontend\controllers\moving;


use booking\entities\Lang;
use booking\repositories\moving\PageRepository;
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

        return $this->render('index', []);
    }


    public function actionView($slug)
    {
        //  scr::p($slug);
        $this->layout = 'main_moving';
        if (!$page = $this->pages->findBySlug($slug)) {
            throw new NotFoundHttpException(Lang::t('Страница не найдена'));
        }

        //TODO Получаем список под папок
        $categories = $page->getChildren()->all();
        return $this->render('view', [
            'page' => $page,
            'categories' => $categories,
        ]);
    }
}