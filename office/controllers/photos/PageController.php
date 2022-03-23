<?php
declare(strict_types=1);

namespace office\controllers\photos;

use booking\entities\Rbac;
use booking\forms\photos\ItemForm;
use booking\forms\photos\PageForm;
use booking\helpers\scr;
use booking\repositories\photos\PageRepository;
use booking\services\photos\PageService;
use office\forms\photos\PageSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class PageController extends Controller
{
    /**
     * @var PageService
     */
    private $service;
    /**
     * @var PageRepository
     */
    private $pages;

    public function __construct($id, $module, PageService $service, PageRepository $pages, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->pages = $pages;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_BLOGGER],
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
        $page = $this->pages->get($id);
        $form = new ItemForm();
        return $this->render('view', [
            'page' => $page,
            'model' => $form,
        ]);
    }

    public function actionCreate()
    {
        $form = new PageForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $page = $this->service->create($form);
                return $this->redirect(Url::to(['view', 'id' => $page->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $page = $this->pages->get($id);

        $form = new PageForm($page);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($page->id, $form);
                return $this->redirect(Url::to(['view', 'id' => $page->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'page' => $page,
        ]);
    }

    public function actionActivate($id): \yii\web\Response
    {
        $this->service->activated($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id): \yii\web\Response
    {
        $this->service->drafted($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(Url::to(['index']));
    }

    public function actionAddItem($id)
    {
        $form = new ItemForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $this->service->addItem($id, $form);
        }
        return $this->redirect(Url::to(['view', 'id' => $id]));
    }
    public function actionEditItem($id, $item_id)
    {
        $page = $this->pages->get($id);
        $item = $page->getItem($item_id);
        $form = new ItemForm($item);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $this->service->editItem($id, $item_id, $form);
        }
        return $this->redirect(Url::to(['view', 'id' => $id]));
    }

    public function actionMoveUp($id, $item_id)
    {
        $this->service->moveUpItem($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDown($id, $item_id)
    {
        $this->service->moveDownItem($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeleteItem($id, $item_id)
    {
        $this->service->removeItem($id, $item_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionGetItem($id, $item_id)
    {
        $this->layout = 'main_ajax';

        if ($item_id == 0) {
            $form = new ItemForm();
            $item = null;
        } else {
            $page = $this->pages->get($id);
            $item = $page->getItem($item_id);
            $form = new ItemForm($item);
        }
        return $this->render('_item', [
            'model' => $form,
            'item' => $item,
            'page_id' => $id,
        ]);
    }
}