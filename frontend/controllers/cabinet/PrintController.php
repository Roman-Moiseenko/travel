<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\repositories\booking\tours\BookingTourRepository;
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

    public function __construct($id, $module, pdfServiceController $pdf, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pdf = $pdf;
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
        //TODO Печать Чека
    }

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

}