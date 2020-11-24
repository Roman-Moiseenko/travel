<?php


namespace admin\controllers;


use booking\entities\Lang;
use booking\helpers\scr;
use booking\repositories\office\HelpRepository;
use booking\repositories\office\PageRepository;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HelpController extends Controller
{
    public $layout = 'main-help';
    private $pages;

    public function __construct($id, $module, HelpRepository $pages, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
    }


    public function actionIndex()
    {
        return $this->redirect(Url::to(['help/view', 'id' => 1]));
    }

    public function actionView($id)
    {
      //  scr::p($slug);
        if (!$page = $this->pages->findById($id)) {
            throw new NotFoundHttpException(Lang::t('Страница не найдена'));
        }

        return $this->render('view', [
            'page' => $page,
        ]);
    }
}