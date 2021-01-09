<?php


namespace booking\services\yandex;


use booking\helpers\BookingHelper;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\tours\TourRepository;
use yii\helpers\Html;
use yii\helpers\Url;

class YandexMarket
{
    private $info;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var FunRepository
     */
    private $funs;

    public function __construct(
        Info $info,
        TourRepository $tours,
        CarRepository $cars,
        FunRepository $funs
    )
    {
        $this->info = $info;
        $this->tours = $tours;
        $this->cars = $cars;
        $this->funs = $funs;
    }

    public function generateTurbo(): string
    {
        ob_start();

        $writer = new \XMLWriter();
        $writer->openURI('php://output');

        $writer->startDocument('1.0', 'UTF-8');
        $writer->startDTD('yml_catalog SYSTEM "shops.dtd"');
        $writer->endDTD();

        $writer->startElement('yml_catalog');
        $writer->writeAttribute('date', date('Y-m-d H:i'));

        $writer->startElement('shop');
        $writer->writeElement('name', Html::encode($this->info->name));
        $writer->writeElement('company', Html::encode($this->info->company));
        $writer->writeElement('url', Html::encode($this->info->url));
        $writer->startElement('currencies');
        $writer->startElement('currency');
        $writer->writeAttribute('id', 'RUR');
        $writer->writeAttribute('rate', 1);
        $writer->endElement();

        $writer->endElement();

        $writer->startElement('categories');

        foreach (BookingHelper::TYPE_OF_LIST as $type) {
            $writer->startElement('category');
            $writer->writeAttribute('id', $type);
            $writer->writeRaw(BookingHelper::STRING_TYPE[$type]);
            $writer->endElement();
        }
        $writer->endElement();
        $writer->startElement('offers');

        // $deliveries = $this->deliveryMethods->getAll();
        $tours = $this->tours->getAllForSitemap();
        foreach ($tours as $tour) {
            $writer->startElement('offer');

            $writer->writeAttribute('id', $tour->id);
            $writer->writeAttribute('type', 'vendor.model');
            $writer->writeAttribute('available', 'true');

            $writer->writeElement('url', Html::encode(Url::to(['/tour/' . $tour->slug], true)));
            $writer->writeElement('price', $tour->baseCost->adult);
            $writer->writeElement('currencyId', 'RUR');
            $writer->writeElement('categoryId', BookingHelper::BOOKING_TYPE_TOUR);

            $writer->writeElement('vendor', Html::encode($tour->legal->getName()));
            $writer->writeElement('model', Html::encode($tour->name));
            $writer->writeElement('typePrefix', Html::encode($tour->type->name));
            $writer->writeElement('description', Html::encode(strip_tags($tour->description)));
            $writer->writeElement('picture', $tour->mainPhoto->getThumbFileUrl('file', 'tours_list'));

            $writer->startElement('param');
            $writer->writeAttribute('name', 'Тип');
            $writer->text($tour->params->private ? 'Индивидуальная' : 'Групповая');
            $writer->endElement();

            $writer->startElement('param');
            $writer->writeAttribute('name', 'Длительность');
            $writer->text($tour->params->duration);
            $writer->endElement();
            $writer->endElement();
        }

        $cars = $this->cars->getAllForSitemap();
        foreach ($cars as $car) {
            $writer->startElement('offer');

            $writer->writeAttribute('id', $car->id);
            $writer->writeAttribute('type', 'vendor.model');
            $writer->writeAttribute('available', 'true');

            $writer->writeElement('url', Html::encode(Url::to(['/car/view', 'id' => $car->id], true)));
            $writer->writeElement('price', $car->cost);
            $writer->writeElement('currencyId', 'RUR');
            $writer->writeElement('categoryId', BookingHelper::BOOKING_TYPE_CAR);

            $writer->writeElement('vendor', Html::encode($car->legal->getName()));
            $writer->writeElement('model', Html::encode($car->name));
            $writer->writeElement('typePrefix', Html::encode($car->type->name));
            $writer->writeElement('description', Html::encode(strip_tags($car->description)));
            $writer->writeElement('picture', $car->mainPhoto->getThumbFileUrl('file', 'cars_list'));

            $writer->startElement('param');
            $writer->writeAttribute('name', 'Минимальное бронирование');
            $writer->text($car->params->min_rent . ' дней');
            $writer->endElement();

            $writer->startElement('param');
            $writer->writeAttribute('name', 'Залог');
            $writer->text($car->deposit);
            $writer->endElement();


            $writer->endElement();
        }

        $funs = $this->funs->getAllForSitemap();
        foreach ($funs as $fun) {
            $writer->startElement('offer');

            $writer->writeAttribute('id', $fun->id);
            $writer->writeAttribute('type', 'vendor.model');
            $writer->writeAttribute('available', 'true');

            $writer->writeElement('url', Html::encode(Url::to(['/fun/view', 'id' => $fun->id], true)));
            $writer->writeElement('price', $fun->baseCost->adult);
            $writer->writeElement('currencyId', 'RUR');
            $writer->writeElement('categoryId', BookingHelper::BOOKING_TYPE_FUNS);

            $writer->writeElement('vendor', Html::encode($fun->legal->getName()));
            $writer->writeElement('model', Html::encode($fun->name));
            $writer->writeElement('typePrefix', Html::encode($fun->type->name));
            $writer->writeElement('description', Html::encode(strip_tags($fun->description)));
            $writer->writeElement('picture', $fun->mainPhoto->getThumbFileUrl('file', 'funs_list'));

            $writer->endElement();
        }

        $writer->endElement();

        $writer->fullEndElement();
        $writer->fullEndElement();

        $writer->endDocument();

        return ob_get_clean();
    }
}