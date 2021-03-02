<?php


namespace frontend\controllers\stays;


use booking\forms\booking\stays\SearchStayForm;
use booking\repositories\booking\stays\StayRepository;
use booking\services\booking\stays\StayService;
use yii\web\Controller;

class StaysController extends Controller
{
    public $layout = 'stays';
    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var StayService
     */
    private $service;

    public function __construct(
        $id,
        $module,
        StayRepository $stays,
        StayService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->stays = $stays;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SearchStayForm();
        if (isset(\Yii::$app->request->queryParams['SearchStayForm'])) {
            $form->load(\Yii::$app->request->get());
            $form->validate();
            $dataProvider = $this->stays->search($form);
        } else {
            $dataProvider = $this->stays->search();
        }

        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }
}