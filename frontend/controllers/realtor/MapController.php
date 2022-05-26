<?php


namespace frontend\controllers\realtor;


use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\helpers\CurrencyHelper;
use booking\repositories\realtor\land\LandRepository;
use yii\helpers\Url;
use yii\web\Controller;

class MapController extends Controller
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

    public function actionIndex(): string
    {
        $lands = $this->lands->getAll();
        return $this->render('index', [
            'lands' => $lands,
        ]);
    }

    public function actionView($slug): string
    {
        $land = $this->lands->findBySlug($slug);

        return $this->render('view', ['land' => $land]);
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
                        'url' => Url::to(['realtor/map/view', 'slug' => $land->slug]),
                        'photo' => $land->getThumbFileUrl('photo', 'for_map'),
                        'cost' => CurrencyHelper::stat($land->cost),
                        'coords' => ['x' => $land->address->latitude, 'y' => $land->address->longitude],
                    ];
                }, $lands);
                return json_encode($array_lands);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

    public function actionGetLand()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $land = $this->lands->get($params['id']);
                $coords = [
                    'x' => $land->address->latitude,
                    'y' => $land->address->longitude,
                    'points' => array_map(function (Point $point) {
                        return [$point->latitude, $point->longitude];
                    }, $land->points),
                    'name' => $land->name,
                ];
                return json_encode($coords);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }
}