<?php


namespace frontend\controllers\cabinet;


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
        /*
        $content = $this->renderPartial('tour', [
            'booking' => $booking,
            ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Krajee Report Title'],
            'methods' => [
                'SetTitle' => Lang::t('Подтверждение бронирования'),
                'SetHeader'=>['Koenigs.travel'],
                'SetFooter'=>['{PAGENO}'],
                'SetAuthor' => 'Koenigs.Travel',
                'SetCreator' => 'Koenigs.Travel',
                'SetKeywords' => 'travel russia koenigsberg booking',
            ]
        ]);

        try {
            return $pdf->render();
        } catch (MpdfException $e) {
        } catch (CrossReferenceException $e) {
        } catch (PdfTypeException $e) {
        } catch (PdfParserException $e) {
        } catch (InvalidConfigException $e) {
        }
*/
         // \Yii::$app->response->format = 'pdf';

         // $this->layout = '//print';
        //  return $this->renderPartial('tour', ['booking' => $booking,]);
    }

}