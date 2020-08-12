<?php


namespace frontend\controllers\tours;


use booking\forms\booking\tours\SearchToursForm;
use booking\repositories\booking\tours\ToursRepository;
use yii\web\Controller;

class ToursController extends Controller
{
    public $layout = 'tours';
    /**
     * @var ToursRepository
     */
    private $tours;

    public function __construct($id, $module, ToursRepository $tours, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tours = $tours;
    }

    public function actionIndex()
    {

        $form = new SearchToursForm();
        $form->load(\Yii::$app->request->post());
        $form->validate();
        $dataProvider = $this->tours->search($form);
        return $this->render('index_top', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTour($id)
    {
        $this->layout = 'tours_blank';
        return $this->render('tour', [
            'id' => $id
        ]);
    }

}