<?php


namespace office\controllers\moving;


use booking\entities\moving\agent\Agent;
use booking\entities\moving\agent\Region;
use booking\entities\Rbac;
use booking\forms\moving\AgentForm;
use booking\forms\moving\RegionForm;
use booking\services\moving\AgentService;
use booking\services\moving\RegionService;
use office\forms\moving\RegionSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AgentController extends Controller
{

    /**
     * @var RegionService
     */
    private $regionService;
    /**
     * @var AgentService
     */
    private $agentService;

    public function __construct(
        $id,
        $module,
        RegionService $regionService,
        AgentService $agentService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->regionService = $regionService;
        $this->agentService = $agentService;
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
        $searchModel = new RegionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewRegion($id)
    {
        $region = Region::findOne($id);
        return $this->render('view-region', [
            'region' => $region,
        ]);
    }

    public function actionCreateRegion()
    {
        $form = new RegionForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $region = $this->regionService->create($form);
                return $this->redirect(['moving/agent/view-region', 'id' => $region->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());

            }
        }
        return $this->render('create-region', [
            'model' => $form
        ]);
    }

    public function actionUpdateRegion($id)
    {
        $region = Region::findOne($id);
        $form = new RegionForm($region);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->regionService->edit($id, $form);
                return $this->redirect(['moving/agent/view-region', 'id' => $region->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update-region', [
            'model' => $form,
            'region' => $region,
        ]);
    }

    public function actionDeleteRegion($id)
    {
        $this->regionService->remove($id);
        return $this->redirect(['index']);
    }

    public function actionMoveUpRegion($id)
    {
        $this->regionService->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionMoveDownRegion($id)
    {
        $this->regionService->moveDown($id);
        return $this->redirect(['index']);
    }

    public function actionViewAgent($id)
    {
        $agent = Agent::findOne($id);
        return $this->render('view-agent', [
            'agent' => $agent,
        ]);
    }

    public function actionCreateAgent($id)
    {
        $region = Region::findOne($id);
        $form = new AgentForm();
        $form->region_id = $region->id;
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $agent = $this->agentService->create($form);
                return $this->redirect(['moving/agent/view-agent', 'id' => $agent->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-agent', [
            'model' => $form,
            'region' => $region,
        ]);
    }

    public function actionUpdateAgent($id)
    {
        $agent = Agent::findOne($id);
        $form = new AgentForm($agent);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->agentService->edit($id, $form);
                return $this->redirect(['moving/agent/view-agent', 'id' => $agent->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-agent', [
            'model' => $form,
            'agent' => $agent,
        ]);
    }

    public function actionDeleteAgent($id)
    {
        $this->agentService->remove($id);
        return $this->redirect(['index']);
    }

    public function actionMoveUpAgent($id)
    {
        $this->agentService->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionMoveDownAgent($id)
    {
        $this->agentService->moveDown($id);
        return $this->redirect(['index']);
    }
}