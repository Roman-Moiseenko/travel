<?php


namespace frontend\controllers;


use booking\entities\Lang;
use booking\repositories\office\PageRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{

    private $pages;

    public function __construct($id, $module, PageRepository $pages, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pages = $pages;
    }

    public function actionView($id)
    {
        if (!$page = $this->pages->find($id)) {
            throw new NotFoundHttpException(Lang::t('Страница не найдена'));
        }

        return $this->render('view', [
            'page' => $page,
        ]);
    }
}