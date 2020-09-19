<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
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

        $content = $this->renderPartial('tour');

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
           // 'cssFile' => '',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetTitle' => Lang::t('Подтверждение бронирования'),
                'SetHeader'=>['Koenigs.travel'],
                'SetFooter'=>['{PAGENO}'],
                'SetAuthor' => 'Koenigs.Travel',
                'SetCreator' => 'Koenigs.Travel',
                'SetKeywords' => 'travel russia koenigsberg booking',
            ]
        ]);

        // return the pdf output as per the destination setting
        try {
            return $pdf->render();
        } catch (MpdfException $e) {
        } catch (CrossReferenceException $e) {
        } catch (PdfTypeException $e) {
        } catch (PdfParserException $e) {
        } catch (InvalidConfigException $e) {
        }

        /*  \Yii::$app->response->format = 'pdf';

          $this->layout = '//print';
          return $this->renderPartial('tour', []);*/
    }
}