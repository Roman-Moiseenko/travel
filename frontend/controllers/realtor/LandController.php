<?php


namespace frontend\controllers\realtor;


use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\repositories\realtor\land\LandRepository;
use yii\web\Controller;

class LandController extends Controller
{

    public $layout = 'main';//_land';
    /**
     * @var LandRepository
     */
    private $lands;

    public function __construct($id, $module, LandRepository $lands, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->lands = $lands;
    }

    public function actionIndex()
    {
        return $this->render('index', []);
    }

}