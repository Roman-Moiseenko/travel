<?php
declare(strict_types=1);

namespace frontend\controllers\photos;

use booking\repositories\photos\PageRepository;
use yii\web\Controller;

class PageController extends Controller
{
    /**
     * @var PageRepository
     */
    private $pages;

    public function __construct($id, $module, PageRepository $pages, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
    }

    public function actionIndex(): string
    {
        $dataProvider = $this->pages->getAll();
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionTag($tag)
    {

    }

    public function actionView($slug)
    {

    }
}