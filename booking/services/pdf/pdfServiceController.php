<?php


namespace booking\services\pdf;


use booking\entities\booking\BaseBooking;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use QRcode;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use YandexCheckout\Request\Receipts\ReceiptResponseInterface;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class pdfServiceController extends Controller
{

    public function pdfFile(BaseBooking $booking, $file = false)
    {
        //TODO ** BOOKING_OBJECT **
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TOUR: $view = 'tour'; break;
            case BookingHelper::BOOKING_TYPE_STAY: $view = 'stay'; break;
            case BookingHelper::BOOKING_TYPE_CAR: $view = 'car'; break;
            case BookingHelper::BOOKING_TYPE_FUNS: $view = 'fun'; break;
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

    public function pdfCheck54(BaseBooking $booking, ReceiptResponseInterface $item, $file = false)
    {
        //Генерируем QR qr.jpg
        $text =
            't='.date('YmdTHis', $item->registered_at->getTimestamp()).
            '&s=' . number_format($booking->getPayment()->getPrepay(), 2, '.', '') .
            '&fn=' . $item->fiscal_storage_number.
            '&i=' . $item->fiscal_document_number .
            '&fp=' . $item->fiscal_attribute.
            '&n='. $item->tax_system_code;
        require_once __DIR__ . '/phpqrcode/qrlib.php';
        QRcode::png($text, \Yii::$app->params['staticPath'] . '/files/temp/qr.png', 'H', 3, 2);
        if ($file) {
            $filename = \Yii::$app->params['staticPath'] . '/files/temp/check_' . uniqid() . '.pdf';
            $destination = Pdf::DEST_FILE;
        } else {
            $filename = null;
            $destination = Pdf::DEST_BROWSER;
        }
        $content = $this->renderPartial('@booking/services/pdf/views/check54', [
            'booking' => $booking,
            'item' => $item
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => [80, 210],
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 5,
            'marginBottom' => 10,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => $destination,
            'content' => $content,
            'filename' => $filename,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Krajee Report Title'],
            'methods' => [
                'SetTitle' => Lang::t('Онлайн чек'),
                //'SetHeader'=>['Koenigs.ru'],
                'SetFooter'=>['Koenigs.ru'],
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