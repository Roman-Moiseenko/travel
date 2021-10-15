<?php


namespace frontend\controllers\realtor;


use booking\repositories\realtor\LandownerRepository;
use yii\web\Controller;

class LandownersController extends Controller
{
    public $layout = 'main_land';
    /**
     * @var LandownerRepository
     */
    private $landowners;

    public function __construct($id, $module, LandownerRepository $landowners, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->landowners = $landowners;
    }

    public function actionIndex()
    {
        $landowners = $this->landowners->getAll();
        return $this->render('index', [
            'landowners' => $landowners
        ]);
    }

    public function actionView($slug)
    {
        $landowner = $this->landowners->findBySlug($slug);
        return $this->render('view', [
            'landowner' => $landowner
        ]);

    }
}