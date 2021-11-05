<?php


namespace frontend\controllers;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\foods\Food;
use booking\entities\forum\Section;
use booking\entities\moving\CategoryFAQ;
use booking\entities\moving\FAQ;
use booking\entities\moving\Page;
use booking\entities\realtor\Landowner;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\repositories\blog\CategoryRepository;
use booking\repositories\blog\PostRepository;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\foods\FoodRepository;
use booking\repositories\forum\SectionRepository;
use booking\repositories\moving\CategoryFAQRepository;
use booking\repositories\moving\FAQRepository;
use booking\repositories\moving\PageRepository;
use booking\repositories\realtor\LandownerRepository;
use booking\repositories\shops\ProductRepository;
use booking\repositories\shops\ShopRepository;
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
    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var \booking\repositories\booking\stays\TypeRepository
     */
    private $stayTypes;
    /**
     * @var FoodRepository
     */
    private $foods;
    /**
     * @var ShopRepository
     */
    private $shops;
    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var PageRepository
     */
    private $moving;
    /**
     * @var CategoryFAQRepository
     */
    private $categoryFAQ;
    /**
     * @var \booking\entities\forum\Category
     */
    private $categoryForum;
    /**
     * @var SectionRepository
     */
    private $sections;
    /**
     * @var \booking\repositories\forum\PostRepository
     */
    private $postForum;
    /**
     * @var \booking\repositories\night\PageRepository
     */
    private $night;
    /**
     * @var LandownerRepository
     */
    private $landowners;


    public function __construct(
        $id,
        $module,
        Sitemap $sitemap,
        TourRepository $tours,
        CarRepository $cars,
        FunRepository $funs,
        StayRepository $stays,
        PostRepository $posts,
        FoodRepository $foods,
        ShopRepository $shops,
        ProductRepository $products,
        \booking\repositories\booking\tours\TypeRepository $tourTypes,
        \booking\repositories\booking\cars\TypeRepository $carTypes,
        \booking\repositories\booking\funs\TypeRepository $funTypes,
        \booking\repositories\booking\stays\TypeRepository $stayTypes,
        CategoryRepository $postType,
        PageRepository $moving,
        \booking\repositories\night\PageRepository $night,
        CategoryFAQRepository $categoryFAQ,
        \booking\repositories\forum\CategoryRepository $categoryForum,
        \booking\repositories\forum\PostRepository $postForum,
        SectionRepository $sections,
        LandownerRepository $landowners,
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
        $this->stays = $stays;
        $this->stayTypes = $stayTypes;
        $this->foods = $foods;
        $this->shops = $shops;
        $this->products = $products;
        $this->moving = $moving;

        $this->categoryFAQ = $categoryFAQ;
        $this->categoryForum = $categoryForum;
        $this->sections = $sections;
        $this->postForum = $postForum;
        $this->night = $night;
        $this->landowners = $landowners;
    }

    public function actionIndex(): Response
    {
        //TODO ** BOOKING_OBJECT **

        return $this->renderSitemap('sitemap-index', function () {
            return $this->sitemap->generateIndex([
                new IndexItem(Url::to(['tours'], true)),
                new IndexItem(Url::to(['tour-categories'], true)),
                new IndexItem(Url::to(['cars'], true)),
                new IndexItem(Url::to(['car-categories'], true)),
                new IndexItem(Url::to(['funs'], true)),
                new IndexItem(Url::to(['fun-categories'], true)),
                new IndexItem(Url::to(['stays'], true)),
//                new IndexItem(Url::to(['stay-categories'], true)),
                new IndexItem(Url::to(['posts'], true)),
                new IndexItem(Url::to(['post-categories'], true)),
                new IndexItem(Url::to(['foods'], true)),
                new IndexItem(Url::to(['shops'], true)),
                new IndexItem(Url::to(['products'], true)),
                new IndexItem(Url::to(['mains'], true)),
                new IndexItem(Url::to(['moving'], true)),
                new IndexItem(Url::to(['realtor'], true)),
                new IndexItem(Url::to(['realtor-landowners'], true)),
                new IndexItem(Url::to(['moving-pages'], true)),
                new IndexItem(Url::to(['night-pages'], true)),
                //new IndexItem(Url::to(['faq-category'], true)),
                new IndexItem(Url::to(['forum'], true)),
                new IndexItem(Url::to(['forum-category'], true)),
                new IndexItem(Url::to(['forum-theme'], true)),
            ]);
        });
    }

    public function actionForum(): Response
    {
        return $this->renderSitemap('sitemap-forum', function () {
            return $this->sitemap->generateMap(array_map(function (Section $section) {
                return new MapItem(
                    Url::to(['/forum/view', 'slug' => $section->slug], true),
                    null,
                    MapItem::DAILY
                );
            }, $this->sections->getAll()));
        });
    }

    public function actionForumCategory(): Response
    {
        return $this->renderSitemap('sitemap-forum-category', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\forum\Category $category) {
                return new MapItem(
                    Url::to(['/forum/category', 'id' => $category->id], true),
                    $category->update_at ?? $category->created_at,
                    MapItem::DAILY
                );
            }, $this->categoryForum->getAll()));
        });
    }

    public function actionForumTheme(): Response
    {
        return $this->renderSitemap('sitemap-forum-theme', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\forum\Post $post) {
                return new MapItem(
                    Url::to(['/forum/post', 'id' => $post->id], true),
                    $post->update_at ?? $post->created_at,
                    MapItem::ALWAYS
                );
            }, $this->postForum->getAllForSitemap()));
        });
    }

    public function actionRealtor(): Response
    {
        return $this->renderSitemap('sitemap-realtor', function () {
            return $this->sitemap->generateMap(array_map(function ($item) {
                return new MapItem(
                    Url::to([$item], true),
                    null,
                    MapItem::ALWAYS
                );
            }, ['/realtor', '/realtor/investment', '/realtor/map', 'realtor/landowners']));
        });
    }

    public function actionRealtorLandowners(): Response
    {
        return $this->renderSitemap('sitemap-forum-theme', function () {
            return $this->sitemap->generateMap(array_map(function (Landowner $landowner) {
                return new MapItem(
                    Url::to(['/realtor/landowners/view', 'id' => $landowner->id], true),
                    $landowner->created_at,
                    MapItem::ALWAYS
                );
            }, $this->landowners->getAll()));
        });
    }

    public function actionMoving(): Response
    {
        return $this->renderSitemap('sitemap-moving', function () {
            return $this->sitemap->generateMap(array_map(function ($item) {
                    return new MapItem(
                        Url::to([$item], true),
                        null,
                        MapItem::ALWAYS
                    );
            }, ['/moving', '/moving/index']));
        });
    }

    public function actionMovingPages(): Response
    {
        return $this->renderSitemap('sitemap-moving-pages', function () {
            return $this->sitemap->generateMap(array_map(function (Page $page) {
                return new MapItem(
                    Url::to(['/moving/moving/view', 'slug' => $page->slug], true),
                    null,
                    MapItem::DAILY
                );
            }, $this->moving->getAll()));
        });
    }
    public function actionNightPages(): Response
    {
        return $this->renderSitemap('sitemap-night-pages', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\night\Page $page) {
                return new MapItem(
                    Url::to(['/night/night/view', 'slug' => $page->slug], true),
                    null,
                    MapItem::DAILY
                );
            }, $this->night->getAll()));
        });
    }
    public function actionMains(): Response
    {
        return $this->renderSitemap('sitemap-mains', function () {
            return $this->sitemap->generateMap(array_map(function ($item) {
                if ($item == '') {
                    return new MapItem(
                        \Yii::$app->params['frontendHostInfo'],
                        null,
                        MapItem::ALWAYS
                    );
                }
                else {
                    return new MapItem(
                        Url::to([$item], true),
                        null,
                        MapItem::ALWAYS
                    );
                }
            }, ['', '/tours', '/cars', '/stays', '/funs', '/about', '/post', '/contacts', '/foods', '/shops', '/avia', '/map', '/help-tour', '/useful']));
        });
    }

    public function actionTours(): Response
    {
        return $this->renderSitemap('sitemap-tours', function () {
            return $this->sitemap->generateMap(array_map(function (Tour $tour) {
                return new MapItem(
                    Url::to(['/tour/view', 'id' => $tour->id], true),
                    $tour->updated_at ?? $tour->created_at,
                    MapItem::DAILY
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

    public function actionStays(): Response
    {
        return $this->renderSitemap('sitemap-stays', function () {
            return $this->sitemap->generateMap(array_map(function (Stay $stay) {
                return new MapItem(
                    Url::to(['/stay/view', 'id' => $stay->id], true),
                    $stay->updated_at ?? $stay->created_at,
                    MapItem::DAILY
                );
            }, $this->stays->getAllForSitemap()));
        });
    }
/*
    public function actionStayCategories(): Response
    {
        return $this->renderSitemap('sitemap-stays-categories', function () {
            return $this->sitemap->generateMap(array_map(function (\booking\entities\booking\stays\Type $type) {
                return new MapItem(
                    Url::to(['/stays/' . $type->slug], true),
                    null,
                    MapItem::ALWAYS
                );
            }, $this->stayTypes->getAll()));
        });
    }
*/
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

    public function actionFoods(): Response
    {
        return $this->renderSitemap('sitemap-foods', function () {
            return $this->sitemap->generateMap(array_map(function (Food $food) {
                return new MapItem(
                    Url::to(['/food/view', 'id' => $food->id], true),
                    $food->created_at,
                    MapItem::WEEKLY
                );
            }, $this->foods->getAllForSitemap()));
        });
    }

    public function actionShops(): Response
    {
        return $this->renderSitemap('sitemap-shops', function () {
            return $this->sitemap->generateMap(array_map(function (Shop $shop) {
                return new MapItem(
                    Url::to(['/shop/catalog/shop', 'id' => $shop->id], true),
                    $shop->updated_at ?? $shop->created_at,
                    MapItem::WEEKLY
                );
            }, $this->shops->getAllForSitemap()));
        });
    }

    public function actionProducts(): Response
    {
        return $this->renderSitemap('sitemap-products', function () {
            return $this->sitemap->generateMap(array_map(function (Product $product) {
                return new MapItem(
                    Url::to(['/shop/catalog/product', 'id' => $product->id], true),
                    $product->updated_at ?? $product->created_at,
                    MapItem::WEEKLY
                );
            }, $this->products->getAllForSitemap()));
        });
    }

    private function renderSitemap($key, callable $callback, Dependency $dependency = null): Response
    {
        return \Yii::$app->response->sendContentAsFile(\Yii::$app->cache->getOrSet($key, $callback, 3600, $dependency), Url::canonical(), [
            'mimeType' => 'application/xml',
            'inline' => true
        ]);
    }

}