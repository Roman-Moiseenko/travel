<?php


namespace office\controllers\touristic;


use booking\entities\Rbac;

use booking\entities\touristic\fun\Category;
use booking\entities\touristic\fun\Fun;
use booking\forms\booking\PhotosForm;
use booking\forms\touristic\fun\CategoryForm;
use booking\forms\touristic\fun\FunForm;
use booking\helpers\scr;
use booking\services\touristic\fun\CategoryService;
use booking\services\touristic\fun\FunService;
use office\forms\touristic\FunCategorySearch;
use office\forms\touristic\FunSearch;
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
    /**
     * @var FunService
     */
    private $funService;

    public function __construct($id, $module, FunService $funService, CategoryService $categoryService, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->categoryService = $categoryService;
        $this->funService = $funService;
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
        $searchModel = new FunSearch([
            'category_id' => $category->id
        ]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('view-category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        $fun = Fun::findOne($id);
        return $this->render('view-fun', [
            'fun' => $fun,
            'category' => $fun->category,
        ]);
    }

    public function actionCreateFun($id)
    {
        $category = Category::findOne($id);
        $form = new FunForm(null, $id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $fun = $this->funService->create($form);
                return $this->redirect(Url::to(['view-fun', 'id' => $fun->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-fun', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionUpdateFun($id)
    {
        $fun = Fun::findOne($id);
        $form = new FunForm($fun);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->funService->edit($id, $form);
                return $this->redirect(Url::to(['view-fun', 'id' => $fun->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-fun', [
            'fun' => $fun,
            'model' => $form,
            'category' => $fun->category,
        ]);
    }

    public function actionDeleteFun($id)
    {
        $fun = Fun::findOne($id);
        $category_id = $fun->category_id;
        $this->funService->remove($id);
        return $this->redirect(Url::to(['view-category', 'id' => $category_id]));
    }

    public function actionMoveUpPhotoFun($id, $photo_id)
    {
        $this->funService->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDownPhotoFun($id, $photo_id)
    {
        $this->funService->movePhotoDown($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeletePhotoFun($id, $photo_id)
    {
        $this->funService->removePhoto($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionPhotoFun($id)
    {
        $fun = Fun::findOne($id);
        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->funService->addPhotos($fun->id, $form);
                return $this->redirect(['view-fun', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('photo-fun', [
            'fun' => $fun,
            'photosForm' => $form,
            'category' => $fun->category,
        ]);
    }


    public function actionActiveFun($id)
    {
        $this->funService->activated($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraftFun($id)
    {
        $this->funService->inactivated($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }


}