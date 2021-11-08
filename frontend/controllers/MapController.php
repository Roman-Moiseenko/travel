<?php


namespace frontend\controllers;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use booking\entities\booking\cars\Car;
use booking\entities\touristic\fun\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\foods\Food;
use booking\entities\forum\Section;
use booking\entities\moving\Page;
use booking\entities\realtor\Landowner;
use booking\entities\shops\products\Product;
use booking\repositories\blog\CategoryRepository;
use booking\repositories\blog\PostRepository;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\touristic\fun\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\foods\FoodRepository;
use booking\repositories\forum\SectionRepository;
use booking\repositories\moving\CategoryFAQRepository;
use booking\repositories\moving\PageRepository;
use booking\repositories\realtor\LandownerRepository;
use booking\repositories\shops\ProductRepository;
use booking\repositories\shops\ShopRepository;
use yii\helpers\Url;
use yii\web\Controller;

class MapController extends Controller
{
    public $layout = 'main';
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
     * @var StayRepository
     */
    private $stays;
    /**
     * @var PostRepository
     */
    private $posts;
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
     * @var \booking\repositories\booking\tours\TypeRepository
     */
    private $tourTypes;
    /**
     * @var \booking\repositories\booking\cars\TypeRepository
     */
    private $carTypes;
    /**
     * @var \booking\repositories\booking\funs\TypeRepository
     */
    private $funTypes;
    /**
     * @var \booking\repositories\booking\stays\TypeRepository
     */
    private $stayTypes;
    /**
     * @var CategoryRepository
     */
    private $postType;
    /**
     * @var PageRepository
     */
    private $moving;
    /**
     * @var \booking\repositories\night\PageRepository
     */
    private $night;
    /**
     * @var CategoryFAQRepository
     */
    private $categoryFAQ;
    /**
     * @var \booking\repositories\forum\CategoryRepository
     */
    private $categoryForum;
    /**
     * @var \booking\repositories\forum\PostRepository
     */
    private $postForum;
    /**
     * @var SectionRepository
     */
    private $sections;
    /**
     * @var LandownerRepository
     */
    private $landowners;
    /**
     * @var \booking\repositories\touristic\fun\CategoryRepository
     */
    private $funCategories;

    public function __construct(
        $id,
        $module,
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
        \booking\repositories\touristic\fun\CategoryRepository $funCategories,
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
        $this->tours = $tours;
        $this->cars = $cars;
        $this->funs = $funs;
        $this->stays = $stays;
        $this->posts = $posts;
        $this->foods = $foods;
        $this->shops = $shops;
        $this->products = $products;
        $this->tourTypes = $tourTypes;
        $this->carTypes = $carTypes;
        $this->funTypes = $funTypes;
        $this->stayTypes = $stayTypes;
        $this->postType = $postType;
        $this->moving = $moving;
        $this->night = $night;
        $this->categoryFAQ = $categoryFAQ;
        $this->categoryForum = $categoryForum;
        $this->postForum = $postForum;
        $this->sections = $sections;
        $this->landowners = $landowners;
        $this->funCategories = $funCategories;
    }

    public function actionIndex()
    {
        return $this->render('index', ['array' => $this->getArray()]);
    }

    private function getArray()
    {
        $result = [];
        $result[] = [
            'lvl' => 0,
            'caption' => 'Главная',
            'link' => Url::to(['/'], true),
        ];
        //TOURS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Экскурсии',
            'link' => Url::to(['/tours'], true),
        ];
        $_items = array_map(function (Tour $tour) {
            return [
                'lvl' => 2,
                'caption' => $tour->getName(),
                'link' => Url::to(['/tour/view', 'id' => $tour->id], true),
            ];
        }, $this->tours->getAllForSitemap());
        $result = array_merge($result, $_items);
        //Type
        $_items = array_map(function (\booking\entities\booking\tours\Type $type) {
            return [
                'lvl' => 2,
                'caption' => $type->name,
                'link' => Url::to(['/tours/' . $type->slug], true),
            ];
        }, $this->tourTypes->getAll());
        $result = array_merge($result, $_items);
        //CARS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Прокат авто',
            'link' => Url::to(['/cars'], true),
        ];
        $_items = array_map(function (Car $car) {
            return [
                'lvl' => 2,
                'caption' => $car->getName(),
                'link' => Url::to(['/car/view', 'id' => $car->id], true),
            ];
        }, $this->cars->getAllForSitemap());
        $result = array_merge($result, $_items);
        //Type
        $_items = array_map(function (\booking\entities\booking\cars\Type $type) {
            return [
                'lvl' => 2,
                'caption' => $type->name,
                'link' => Url::to(['/cars/' . $type->slug], true),
            ];
        }, $this->carTypes->getAll());
        $result = array_merge($result, $_items);
        //FUNS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Развлечения',
            'link' => Url::to(['/funs'], true),
        ];
        $_items = array_map(function (Fun $fun) {
            return [
                'lvl' => 2,
                'caption' => $fun->getName(),
                'link' => Url::to(['/funs/funs/fun', 'id' => $fun->id], true),
            ];
        }, $this->funs->getAllForSitemap());
        $result = array_merge($result, $_items);
        //Type
        $_items = array_map(function (\booking\entities\touristic\fun\Category $category) {
            return [
                'lvl' => 2,
                'caption' => $category->name,
                'link' => Url::to(['/funs/category', 'id' => $category->id], true),
            ];
        }, $this->funCategories->getAll());
        $result = array_merge($result, $_items);
        //STAYS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Жилье',
            'link' => Url::to(['/stays'], true),
        ];
        $_items = array_map(function (Stay $stay) {
            return [
                'lvl' => 2,
                'caption' => $stay->getName(),
                'link' => Url::to(['/stay/view', 'id' => $stay->id], true),
            ];
        }, $this->stays->getAllForSitemap());
        $result = array_merge($result, $_items);

        //FOODS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Где поесть',
            'link' => Url::to(['/foods'], true),
        ];
        $_items = array_map(function (Food $food) {
            return [
                'lvl' => 2,
                'caption' => $food->getName(),
                'link' => Url::to(['/food/view', 'id' => $food->id], true),
            ];
        }, $this->foods->getAllForSitemap());
        $result = array_merge($result, $_items);

        //SHOPS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Что купить',
            'link' => Url::to(['/shops'], true),
        ];
        $_items = array_map(function (Product $product) {
            return [
                'lvl' => 2,
                'caption' => $product->getName(),
                'link' => Url::to(['/shop/catalog/product', 'id' => $product->id], true),
            ];
        }, $this->products->getAllForSitemap());
        $result = array_merge($result, $_items);

        //POSTS
        $result[] = [
            'lvl' => 1,
            'caption' => 'Достопримечательности Калининграда',
            'link' => Url::to(['/posts'], true),
        ];
        $_items = array_map(function (Post $post) {
            return [
                'lvl' => 2,
                'caption' => $post->title,
                'link' => Url::to(['/post/view', 'id' => $post->id], true),
            ];
        }, $this->posts->getAllForSitemap());
        $result = array_merge($result, $_items);
        //Type
        $_items = array_map(function (Category $type) {
            return [
                'lvl' => 2,
                'caption' => $type->name,
                'link' => Url::to(['/post/' . $type->slug], true),
            ];
        }, $this->postType->getAll());
        $result = array_merge($result, $_items);

        //FORUM
        $result[] = [
            'lvl' => 1,
            'caption' => 'Форум Калининграда',
            'link' => Url::to(['/forum'], true),
        ];
        $_items = array_map(function (Section $section) {
            return [
                'lvl' => 2,
                'caption' => $section->caption,
                'link' => Url::to(['/forum/view', 'slug' => $section->slug], true),
            ];
        }, $this->sections->getAll());
        $result = array_merge($result, $_items);
        //Category
        $_items = array_map(function (\booking\entities\forum\Category $category) {
            return [
                'lvl' => 3,
                'caption' => $category->name,
                'link' => Url::to(['/forum/category', 'id' => $category->id], true),
            ];
        }, $this->categoryForum->getAll());
        $result = array_merge($result, $_items);

        //Theme
        $_items = array_map(function (\booking\entities\forum\Post $post) {
            return [
                'lvl' => 4,
                'caption' => $post->caption,
                'link' => Url::to(['/forum/post', 'id' => $post->id], true),
            ];
        }, $this->postForum->getAllForSitemap());
        $result = array_merge($result, $_items);

        //Realtor
        $result[] = [
            'lvl' => 1,
            'caption' => 'Приватное риелторское агентство',
            'link' => Url::to(['/realtor'], true),
        ];
        $result[] = [
            'lvl' => 2,
            'caption' => 'Участки',
            'link' => Url::to(['/realtor/landowners'], true),
        ];
        $_items = array_map(function (Landowner $landowner) {
            return [
                'lvl' => 3,
                'caption' => $landowner->name,
                'link' => Url::to(['/realtor/landowners/view', 'id' => $landowner->id], true),
            ];
        }, $this->landowners->getAll());
        $result = array_merge($result, $_items);

        $result[] = [
            'lvl' => 2,
            'caption' => 'Инвестиции в землю',
            'link' => Url::to(['/realtor/investment'], true),
        ];
        $result[] = [
            'lvl' => 2,
            'caption' => 'Карта участков',
            'link' => Url::to(['/realtor/map'], true),
        ];

        //MOVING
        $result[] = [
            'lvl' => 1,
            'caption' => 'Переезд на ПМЖ',
            'link' => Url::to(['/moving'], true),
        ];
        $_items = array_map(function (Page $page) {
            return [
                'lvl' => 2,
                'caption' => $page->name,
                'link' => Url::to(['/moving/moving/view', 'slug' => $page->slug], true),
            ];
        }, $this->moving->getAll());
        $result = array_merge($result, $_items);

        //NIGHT
        $result[] = [
            'lvl' => 1,
            'caption' => 'Переезд на ПМЖ',
            'link' => Url::to(['/moving'], true),
        ];
        $_items = array_map(function (\booking\entities\night\Page $page) {
            return [
                'lvl' => 2,
                'caption' => $page->name,
                'link' => Url::to(['/night/night/view', 'slug' => $page->slug], true),
            ];
        }, $this->night->getAll());
        $result = array_merge($result, $_items);

        //OTHER
        $result[] = [
            'lvl' => 1,
            'caption' => 'О нас',
            'link' => Url::to(['/about'], true),
        ];
        $result[] = [
            'lvl' => 1,
            'caption' => 'Как заказать экскурсию',
            'link' => Url::to(['/help-tour'], true),
        ];

        $result[] = [
            'lvl' => 1,
            'caption' => 'Полезная информация',
            'link' => Url::to(['/useful'], true),
        ];
        $result[] = [
            'lvl' => 1,
            'caption' => 'Кёнигс.РУ',
            'link' => Url::to(['/contacts'], true),
        ];
        $result[] = [
            'lvl' => 1,
            'caption' => 'Авиабилеты',
            'link' => Url::to(['/avia'], true),
        ];


        return $result;
    }


}