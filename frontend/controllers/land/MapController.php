<?php


namespace frontend\controllers\land;


use booking\entities\land\Land;
use booking\entities\land\Point;
use booking\repositories\land\LandRepository;
use yii\web\Controller;

class MapController extends Controller
{

    public $layout = 'main_land';
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

    public function actionGetLands()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $lands = $this->lands->getAll();
                $array_lands = array_map(function (Land $land) {
                    return [
                        'name' => urldecode($land->name),
                        'id' => $land->id,
                        'min_price' => $land->min_price,
                        'count' => $land->count,
                        'coords' => array_map(function (Point $point) {
                            return [$point->latitude, $point->longitude];
                        }, $land->points),
                    ];
                }, $lands);
                return json_encode($array_lands);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }
}