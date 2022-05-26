<?php


namespace frontend\controllers\realtor;


use booking\forms\realtor\BookingLandowner;
use booking\repositories\realtor\LandownerRepository;
use booking\services\ContactService;
use yii\web\Controller;

class LandownersController extends Controller
{
    public $layout = 'main'; //_land
    /**
     * @var LandownerRepository
     */
    private $landowners;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct($id, $module, LandownerRepository $landowners, ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->landowners = $landowners;
        $this->contact = $contact;
    }

    public function actionIndex()
    {
        $landowners = $this->landowners->getAll();
        return $this->render('index', [
            'landowners' => $landowners
        ]);
    }

    public function actionView($slug)
    {
        $landowner = $this->landowners->findBySlug($slug);
        return $this->render('view', [
            'landowner' => $landowner
        ]);
    }

    public function actionBooking()
    {
        $form = new BookingLandowner();
        if ($form->load(\Yii::$app->request->post()) /* && $form->validate()*/) {
            try {
                $this->contact->sendBookingLandowner($form);
                \Yii::$app->session->setFlash('success', 'Ваша заявка отправлена!');
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', 'Что-то пошло не так! Коля, звони в полицию!');
            }
        } else {
            \Yii::$app->session->setFlash('warning', 'Ошибка отправки, попробуйте позже!');
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}