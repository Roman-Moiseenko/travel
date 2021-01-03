<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\finance\YKassaService;
use booking\services\pdf\pdfServiceController;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\web\Controller;

class PrintController extends Controller
{

    /**
     * @var pdfServiceController
     */
    private $pdf;
    /**
     * @var YKassaService
     */
    private $kassaService;
    /**
     * @var BookingRepository
     */
    private $bookings;

    public function __construct($id, $module, pdfServiceController $pdf, YKassaService $kassaService, BookingRepository $bookings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pdf = $pdf;
        $this->kassaService = $kassaService;
        $this->bookings = $bookings;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        //'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCheck($id)
    {
        $booking = $this->bookings->getByPaymentId($id);
        try {
            $item = $this->kassaService->check($id);
            return $this->pdf->pdfCheck54($booking, $item);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('warning', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    //TODO Заглушка Stay
    public function actionTour($id)
    {
        $booking = BookingTour::findOne($id);
        return $this->pdf->pdfFile($booking);
    }

    public function actionCar($id)
    {
        $booking = BookingCar::findOne($id);
        return $this->pdf->pdfFile($booking);
    }

    public function actionFun($id)
    {
        $booking = BookingFun::findOne($id);
        return $this->pdf->pdfFile($booking);
    }

}