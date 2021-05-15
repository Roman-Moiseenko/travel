<?php


namespace frontend\controllers\moving;


use booking\repositories\moving\CategoryFAQRepository;
use yii\web\Controller;

class FaqController extends Controller
{


    public $layout = 'main_moving';
    /**
     * @var CategoryFAQRepository
     */
    private $repository;

    public function __construct($id, $module, CategoryFAQRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionIndex()
    {
        $categories = $this->repository->getAll();
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }
}