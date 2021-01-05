<?php


namespace frontend\controllers;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\tours\Tour;
use booking\repositories\blog\CategoryRepository;
use booking\repositories\blog\PostRepository;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\sitemap\IndexItem;
use booking\services\sitemap\MapItem;
use booking\services\sitemap\Sitemap;
use yii\caching\Dependency;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SitemapController extends Controller
{

    /**
     * @var Sitemap
     */
    private $sitemap;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var FunRepository
     */
    private $funs;
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var \booking\entities\booking\tours\Type
     */
    private $tourTypes;
    /**
     * @var \booking\entities\booking\cars\Type
     */
    private $carTypes;
    /**
     * @var \booking\entities\booking\funs\Type
     */
    private $funTypes;
    /**
     * @var CategoryRepository
     */
    private $postType;

    public function __construct(
        $id,
        $module,
        Sitemap $sitemap,
        TourRepository $tours,
        CarRepository $cars,
        FunRepository $funs,
        PostRepository $posts,
        \booking\repositories\booking\tours\TypeRepository $tourTypes,
        \booking\repositories\booking\cars\TypeRepository $carTypes,
        \booking\repositories\booking\funs\TypeRepository $funTypes,
        CategoryRepository $postType,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->sitemap = $sitemap;
        $this->tours = $tours;
        $this->cars = $cars;
        $this->funs = $funs;
        $this->posts = $posts;
        $this->tourTypes = $tourTypes;
        $this->carTypes = $carTypes;
        $this->funTypes = $funTypes;
        $this->postType = $postType;
    }

    public function actionIndex(): Response
    {
        // TODO заглушка Stay
        /* */
        return $this->renderSitemap('sitemap-index', function () {
            return $this->sitemap->generateIndex([
                new IndexItem(Url::to(['tours'], true)),
                new IndexItem(Url::to(['tour-categories'], true)),
                new IndexItem(Url::to(['cars'], true)),
                new IndexItem(Url::to(['car-categories'], true)),
                new IndexItem(Url::to(['funs'], true)),
                new IndexItem(Url::to(['fun-categories'], true)),
                new IndexItem(Url::to(['posts'], true)),
                new IndexItem(Url::to(['post-categories'], true)),
                new IndexItem(Url::to(['mains'], true)),
            ]);
        });
    }

    public function actionMains(): Response
    {
        return $this->renderSitemap('sitemap-mains', function () {
            return $this->sitemap->generateMap(array_map(function ($item) {
                return new MapItem(
                    Url::to([$item], true),
                    null,
                    MapItem::ALWAYS
                );
            }, ['/tours', '/cars', '/funs', '/about', '/contacts']));
        });
    }

    public function actionTours(): Response
    {
        return $this->renderSitemap('sitemap-tours', function () {
            return $this->sitemap->generateMap(array_map(function (Tour $tour) {
                return new MapItem(
                    Url::to(['/tour/view', 'id' => $tour->id], true),
                    $tour->updated_at ?? $tour->created_at,
                    MapItem::WEEKLY
                );
            }, $this->tours->getAllForSitemap()));
        });
    }

    public function actionTourCategories(): Response
    {
        return $this->renderSitemap('sitemap-tour-categories', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\booking\tours\Type $type) {
                return new MapItem(
                    Url::to(['/tours/' . $type->slug], true),
                    null,
                    MapItem::ALWAYS
                );
            }, $this->tourTypes->getAll()));
        });
    }

    public function actionCars(): Response
    {
        return $this->renderSitemap('sitemap-cars', function () {
            return $this->sitemap->generateMap(array_map(function (Car $car) {
                return new MapItem(
                    Url::to(['/car/view', 'id' => $car->id], true),
                    $car->updated_at ?? $car->created_at,
                    MapItem::WEEKLY
                );
            }, $this->cars->getAllForSitemap()));
        });
    }

    public function actionCarCategories(): Response
    {
        return $this->renderSitemap('sitemap-car-categories', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\booking\cars\Type $type) {
                return new MapItem(
                    Url::to(['/cars/' . $type->slug], true),
                    null,
                    MapItem::ALWAYS
                );
            }, $this->carTypes->getAll()));
        });
    }

    public function actionFuns(): Response
    {
        return $this->renderSitemap('sitemap-funs', function () {
            return $this->sitemap->generateMap(array_map(function (Fun $fun) {
                return new MapItem(
                    Url::to(['/fun/view', 'id' => $fun->id], true),
                    $fun->updated_at ?? $fun->created_at,
                    MapItem::WEEKLY
                );
            }, $this->funs->getAllForSitemap()));
        });
    }

    public function actionFunCategories(): Response
    {
        return $this->renderSitemap('sitemap-fun-categories', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\booking\funs\Type $type) {
                return new MapItem(
                    Url::to(['/funs/' . $type->slug], true),
                    null,
                    MapItem::ALWAYS
                );
            }, $this->funTypes->getAll()));
        });
    }

    public function actionPosts(): Response
    {
        return $this->renderSitemap('sitemap-posts', function () {
            return $this->sitemap->generateMap(array_map(function (Post $post) {
                return new MapItem(
                    Url::to(['/post/view', 'id' => $post->id], true),
                    $post->public_at,
                    MapItem::WEEKLY
                );
            }, $this->posts->getAllForSitemap()));
        });
    }

    public function actionPostCategories(): Response
    {
        return $this->renderSitemap('sitemap-post-categories', function () {
            return $this->sitemap->generateMap(array_map(function (Category $type) {
                return new MapItem(
                    Url::to(['/post/' . $type->slug], true),
                    null,
                    MapItem::ALWAYS
                );
            }, $this->postType->getAll()));
        });
    }

    private function renderSitemap($key, callable $callback, Dependency $dependency = null): Response
    {
        return \Yii::$app->response->sendContentAsFile(\Yii::$app->cache->getOrSet($key, $callback, 4 * 3600, $dependency), Url::canonical(), [
            'mimeType' => 'application/xml',
            'inline' => true
        ]);
    }

}