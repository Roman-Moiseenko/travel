<?php


namespace frontend\controllers\shop;


use booking\forms\booking\ReviewForm;
use booking\repositories\shops\CategoryRepository;
use booking\repositories\shops\ProductRepository;
use booking\repositories\shops\ShopRepository;
use booking\services\shops\AdProductService;
use booking\services\shops\ProductService;
use booking\services\shops\ShopService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'shops';
    /**
     * @var ProductService
     */
    private $service;

    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var CategoryRepository
     */
    private $categories;
    /**
     * @var ShopRepository
     */
    private $shops;
    /**
     * @var ShopService
     */
    private $shopService;

    public function __construct(
        $id,
        $module,
        ProductService $service,
        ProductRepository $products,
        ShopService $shopService,
        CategoryRepository $categories,
        ShopRepository $shops,
        //TagReadRepository $tags,
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->products = $products;
        $this->categories = $categories;
        $this->shops = $shops;
        $this->shopService = $shopService;
    }

    public function actionIndex()
    {
        $category = $this->categories->getRoot();
        $dataProvider = $this->products->getAll();


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }

    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('Категория не найдена');
        }
        $dataProvider = $this->products->getAllByCategory($category);
        // if ($category->depth < 2) {
        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
        /*} else {

            $this->layout = 'catalog_filter';
            $form = new SearchForm();
            $form->category = $id;
            $form->setAttribute($id);
            $form->load(\Yii::$app->request->queryParams);
            $form->validate();
            $dataProvider = $this->products->search($category->id);
            return $this->render('category_filter', [
                'dataProvider' => $dataProvider,
                'category' => $category,
               // 'searchForm' => $form,
            ]);
            */
        //}
    }

    public function actionShop($id)
    {
        $this->layout = 'blank';
        try {
            $shop = $this->shops->getForFrontend($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->shopService->addReview($id, \Yii::$app->user->id, $reviewForm);
                \Yii::$app->session->setFlash('success', 'Ваш отзыв был опубликован. Спасибо!');
                return $this->redirect(['shop/' . $id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('shop', [
            'shop' => $shop,
        ]);
    }

    public function actionMaterial($id)
    {
        /* if (!$tag = $this->tags->find($id)) {
             throw new NotFoundHttpException('Метка не найдена');
         }
         $dataProvider = $this->products->getAllByTag($tag);
         return $this->render('material', [
             'dataProvider' => $dataProvider,
             'tag' => $tag,
         ]);*/
    }

    public function actionProduct($id)
    {
        $this->layout = 'blank';
        try {
            $product = $this->products->getForFrontend($id);
            $this->service->view($product->id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
        // $addToCartForm = new AddToCartForm($product);
        /*    if ($addToCartForm->load(Yii::$app->request->post()) && $addToCartForm->validate()) {
            }*/

        $reviewForm = new ReviewForm();
        if ($reviewForm->load(\Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($id, \Yii::$app->user->id, $reviewForm);
                \Yii::$app->session->setFlash('success', 'Ваш отзыв был опубликован. Спасибо!');
                return $this->redirect(['shop/product/' . $id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('product', [
            'product' => $product,
            //   'addToCartForm' => $addToCartForm,
        ]);
    }

    /*   public function actionSearch()
       {
           $form = new SearchForm();

           if (isset(\Yii::$app->request->queryParams['category'])) {
               $id = \Yii::$app->request->queryParams['category'];
               $form->category = $id;
               $form->setAttribute($id);
           }

           $form->load(\Yii::$app->request->queryParams);
           $form->validate();
           $dataProvider = $this->products->search($form);

           return $this->render('search', [
               'dataProvider' => $dataProvider,
               'searchForm' => $form,
           ]);
       }*/

    /*
        public function actionGetsearch()
        {
            $this->layout = '_blank';
            if (\Yii::$app->request->isAjax) {
                $form = new SearchForm();
                $form->text = \Yii::$app->request->bodyParams['text'];
                $form->brand = \Yii::$app->request->bodyParams['brand'];
                if (isset(\Yii::$app->request->bodyParams['id'])) {
                    $id = \Yii::$app->request->bodyParams['id'];
                    $form->category = $id;
                    $form->setAttribute($id);
                }
                return $this->render('_search', [
                    'searchForm' => $form,
                ]);
            }
        }*/
}