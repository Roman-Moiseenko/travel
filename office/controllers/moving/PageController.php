<?php


namespace office\controllers\moving;

use booking\entities\moving\Page;
use booking\entities\Rbac;
use booking\forms\moving\ItemForm;
use booking\forms\moving\ItemPostForm;
use booking\forms\moving\PageForm;
use booking\services\moving\ItemPostService;
use booking\services\moving\PageManageService;
use office\forms\moving\PageSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{

    /**
     * @var PageManageService
     */
    private $service;
    /**
     * @var ItemPostService
     */
    private $postService;

    public function __construct($id, $module, PageManageService $service, ItemPostService $postService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->postService = $postService;
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
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'page' => $this->findModel($id),
        ]);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $form = new PageForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $page = $this->service->create($form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $page = $this->findModel($id);
        $form = new PageForm($page);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //var_dump($form->meta); exit();
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'page' => $page,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /* ***************************************************  */

    public function actionItems($id)
    {
        $page = $this->findModel($id);
        return $this->render('items', [
            'page' => $page,
        ]);
    }

    public function actionItemCreate($id)
    {
        $page = $this->findModel($id);
        $form = new ItemForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $item = $this->service->addItem($id, $form);
                return $this->redirect(['item', 'id' => $page->id, 'item_id' => $item->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('items-create', [
            'page' => $page,
            'model' => $form,
        ]);
    }

    public function actionItemUpdate($id, $item_id)
    {
        $page = $this->findModel($id);
        $item = $page->getItem($item_id);
        $form = new ItemForm($item);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateItem($id, $item_id, $form);
                return $this->redirect(['item', 'id' => $page->id, 'item_id' => $item->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('items-update', [
            'page' => $page,
            'model' => $form,
            'item' => $item,
        ]);
    }

    public function actionItem($id, $item_id)
    {
        $page = $this->findModel($id);
        $item = $page->getItem($item_id);
        return $this->render('item-view', [
            'page' => $page,
            'item' => $item,
        ]);
    }

    public function actionItemMoveDown($id, $item_id)
    {
        $this->service->itemMoveDown($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionItemMoveUp($id, $item_id)
    {
        $this->service->itemMoveUp($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionItemDelete($id, $item_id)
    {
        $this->service->itemDelete($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeletePhoto($id, $item_id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $item_id, $photo_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionItemPost($id, $item_id)
    {
        $page = $this->findModel($id);
        $form = new ItemPostForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->postService->addPost($item_id, $form);
                //return $this->redirect(['item', 'id' => $page->id, 'item_id' => $item->id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('items-post', [
            'page' => $page,
            'model' => $form,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
