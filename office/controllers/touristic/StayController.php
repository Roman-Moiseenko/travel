<?php


namespace office\controllers\touristic;


use booking\entities\Rbac;

use booking\entities\touristic\stay\Category;
use booking\forms\booking\PhotosForm;
use booking\forms\touristic\stay\CategoryForm;
use booking\services\touristic\stay\StayService;
use booking\services\touristic\stay\CategoryService;

use office\forms\touristic\StayCategorySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class StayController extends Controller
{

    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var StayService
     */
    private $stayService;

    public function __construct($id, $module, StayService $stayService, CategoryService $categoryService, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->categoryService = $categoryService;
        $this->stayService = $stayService;
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
        $searchModel = new StayCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewCategory($id)
    {
        $category = Category::findOne($id);
        /*$searchModel = new StaySearch([
            'category_id' => $category->id
        ]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);*/

        return $this->render('view-category', [
            'category' => $category,
           /* 'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,*/
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
/*
    public function actionViewStay($id)
    {
        $stay = Stay::findOne($id);
        return $this->render('view-stay', [
            'stay' => $stay,
            'category' => $stay->category,
        ]);
    }

    public function actionCreateStay($id)
    {
        $category = Category::findOne($id);
        $form = new StayForm(null, $id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $stay = $this->stayService->create($form);
                return $this->redirect(Url::to(['view-stay', 'id' => $stay->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-stay', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionUpdateStay($id)
    {
        $stay = Stay::findOne($id);
        $form = new StayForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->stayService->edit($id, $form);
                return $this->redirect(Url::to(['view-stay', 'id' => $stay->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-stay', [
            'stay' => $stay,
            'model' => $form,
            'category' => $stay->category,
        ]);
    }

    public function actionDeleteStay($id)
    {
        $stay = Stay::findOne($id);
        $category_id = $stay->category_id;
        $this->stayService->remove($id);
        return $this->redirect(Url::to(['view-category', 'id' => $category_id]));
    }
    public function actionMoveUpStay($category_id, $id)
    {
        $this->stayService->moveUp($category_id, $id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDownStay($category_id, $id)
    {
        $this->stayService->moveDown($category_id, $id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveUpPhotoStay($id, $photo_id)
    {
        $this->stayService->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDownPhotoStay($id, $photo_id)
    {
        $this->stayService->movePhotoDown($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeletePhotoStay($id, $photo_id)
    {
        $this->stayService->removePhoto($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionPhotoStay($id)
    {
        $stay = Stay::findOne($id);
        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->stayService->addPhotos($stay->id, $form);
                return $this->redirect(['view-stay', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('photo-stay', [
            'stay' => $stay,
            'photosForm' => $form,
            'category' => $stay->category,
        ]);
    }


    public function actionActiveStay($id)
    {
        $this->stayService->activated($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraftStay($id)
    {
        $this->stayService->inactivated($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

*/
}