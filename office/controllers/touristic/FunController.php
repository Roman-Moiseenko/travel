<?php


namespace office\controllers\touristic;


use booking\entities\Rbac;

use booking\entities\touristic\fun\Category;
use booking\forms\touristic\fun\CategoryForm;
use booking\services\touristic\fun\CategoryService;
use office\forms\touristic\FunCategorySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class FunController extends Controller
{

    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct($id, $module,/* FunService $funService, */ CategoryService $categoryService, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->categoryService = $categoryService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FunCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionViewCategory($id)
    {
        $category = Category::findOne($id);
        return $this->render('view-category', [
            'category' => $category,
        ]);
    }

    public function actionCreateCategory()
    {
        $form = new CategoryForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $category = $this->categoryService->create($form);
                return $this->redirect(Url::to(['view-category', 'id' => $category->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-category', [
            'model' => $form,
        ]);
    }

    public function actionUpdateCategory($id)
    {
        $category = Category::findOne($id);
        $form = new CategoryForm($category);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                 $this->categoryService->edit($category->id, $form);
                return $this->redirect(Url::to(['view-category', 'id' => $category->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-category', [
            'category' => $category,
            'model' => $form,
        ]);
    }

    public function actionDeleteCategory($id)
    {
        $this->categoryService->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveUpCategory($id)
    {
        $this->categoryService->moveUp($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDownCategory($id)
    {
        $this->categoryService->moveDown($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionViewFun($id)
    {

    }

    public function actionCreateFun($id)
    {

    }

    public function actionUpdateFun($id)
    {

    }

    public function actionDeleteFun($id)
    {

    }

    public function actionMoveUpFun($id)
    {

    }

    public function actionMoveDownFun($id)
    {

    }


    public function actionActiveFun($id)
    {
      /*  $fun = $this->find($id);
        $this->serviceFun->activate($fun->id);
        return $this->redirect(\Yii::$app->request->referrer);*/
    }

    public function actionDraftFun($id)
    {
       /* $fun = $this->find($id);
        $this->serviceFun->lock($fun->id);
        return $this->redirect(\Yii::$app->request->referrer);*/
    }


}