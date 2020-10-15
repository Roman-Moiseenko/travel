<?php


namespace booking\services\pdf;


use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class pdfServiceController extends Controller
{

    public function pdfFile(BookingItemInterface $booking, $file = false)
    {

        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TOUR: $view = 'tour'; break;
            case BookingHelper::BOOKING_TYPE_STAY: $view = 'stay'; break;
            case BookingHelper::BOOKING_TYPE_CAR: $view = 'car'; break;
            default: $view = 'error';
        }
        if ($file) {
            $filename = \Yii::$app->params['staticPath'] . '/files/temp/notice_' . uniqid() . '.pdf';
            $destination = Pdf::DEST_FILE;
        } else {
            $filename = null;
            $destination = Pdf::DEST_BROWSER;
        }
        $content = $this->renderPartial('@booking/services/pdf/views/' . $view, [
            'booking' => $booking,
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => $destination,
            'content' => $content,
            'filename' => $filename,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Krajee Report Title'],
            'methods' => [
                'SetTitle' => Lang::t('Подтверждение бронирования'),
                'SetHeader'=>['Koenigs.ru'],
                'SetFooter'=>['{PAGENO}'],
                'SetAuthor' => 'Koenigs.ru',
                'SetCreator' => 'Koenigs.ru',

            ]
        ]);

        try {
            if ($file) {
                $pdf->render();
                return $filename;
            } else {
                return $pdf->render();
            }
        } catch (MpdfException $e) {
        } catch (CrossReferenceException $e) {
        } catch (PdfTypeException $e) {
        } catch (PdfParserException $e) {
        } catch (InvalidConfigException $e) {
        }
    }


}