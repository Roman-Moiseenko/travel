<?php


namespace frontend\controllers\moving;


use booking\repositories\moving\RegionRepository;
use yii\helpers\Url;
use yii\web\Controller;

class AgentsController extends Controller
{
    public $layout = 'main';//_moving';
    /**
     * @var RegionRepository
     */
    private $regions;

    public function __construct($id, $module, RegionRepository $regions, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->regions = $regions;
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'regions' => $this->regions->getAll()
        ]);
    }
}