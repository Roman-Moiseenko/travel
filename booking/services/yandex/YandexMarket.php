<?php


namespace booking\services\yandex;


use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\blog\PostRepository;
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
    /**
     * @var PostRepository
     */
    private $post;

    public function __construct(
        Info $info,
        TourRepository $tours,
        CarRepository $cars,
        FunRepository $funs,
        PostRepository $post
    )
    {
        $this->info = $info;
        $this->tours = $tours;
        $this->cars = $cars;
        $this->funs = $funs;
        $this->post = $post;
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
            $writer->writeElement('picture', $tour->mainPhoto->getThumbFileUrl('file', 'list'));

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
            $writer->writeElement('picture', $car->mainPhoto->getThumbFileUrl('file', 'list'));

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
            $writer->writeElement('picture', $fun->mainPhoto->getThumbFileUrl('file', 'list'));

            $writer->endElement();
        }

        $writer->endElement();

        $writer->fullEndElement();
        $writer->fullEndElement();

        $writer->endDocument();

        return ob_get_clean();
    }

    public function generateRss(): string
    {
        ob_start();

        $writer = new \XMLWriter();
        $writer->openURI('php://output');

        $writer->startDocument('1.0', 'UTF-8');
        /*$writer->startDTD('yml_catalog SYSTEM "shops.dtd"');
        $writer->endDTD();*/

        $writer->startElement('rss');
        $writer->writeAttribute('xmlns:yandex', 'http://news.yandex.ru');
        $writer->writeAttribute('xmlns:media', 'http://search.yahoo.com/mrss/');
        $writer->writeAttribute('xmlns:turbo', 'http://turbo.yandex.ru');
        $writer->writeAttribute('version', '2.0');

        $writer->startElement('channel');
        $writer->writeElement('title', Html::encode('Блог о Калининграде'));
        $writer->writeElement('link', Url::to(['/post'], true));
        $writer->writeElement('description', Html::encode('Обзорные статьи о Калининграде и области'));
        $writer->writeElement('language', 'ru');
        $writer->writeElement('turbo:analytics');
        $writer->writeElement('turbo:adNetwork');

        $post = $this->post->getAllForSitemap();
        foreach ($post as $item) {
            $writer->startElement('item');
            $writer->writeAttribute('turbo', 'true');
            $writer->writeElement('turbo:extendedHtml', 'true');
            $writer->writeElement('link', Url::to(['/post/view', 'id' => $item->id], true));
            $writer->writeElement('turbo:source');
            $writer->writeElement('turbo:topic');
            $writer->writeElement('pubDate', date('Y-m-d H:i', $item->public_at));
            $writer->writeElement('author', 'ООО Кёнигс.РУ');
            $writer->startElement('metrics');
            $writer->startElement('yandex');

            $writer->startElement('metrics');
            $writer->writeAttribute('schema_identifier', '70580203');




            $writer->startElement('breadcrumblist');

            $writer->startElement('breadcrumb');
            $writer->writeAttribute('url', Url::to(['/post'], true));
            $writer->writeAttribute('text', 'Блог');
            $writer->endElement();
            $writer->startElement('breadcrumb');
            $writer->writeAttribute('url', Url::to(['/post/category', 'slug' => $item->category->slug], true));
            $writer->writeAttribute('text', $item->category->getName());
            $writer->endElement();
            $writer->startElement('breadcrumb');

            $writer->writeAttribute('url', Url::to(['/post/view', 'id' => $item->id], true));
            $writer->writeAttribute('text', $item->getTitle());
            $writer->endElement();

            $writer->endElement();
            $writer->endElement();

            $writer->endElement();

            $writer->writeElement('yandex:related');

            $writer->startElement('turbo:content');
            $writer->text('<![CDATA[' . $item->content . ']]>');


            $writer->endElement();

            $writer->endElement();

        }


        $writer->endElement();
        $writer->endElement();

        $writer->fullEndElement();
        $writer->fullEndElement();

        $writer->endDocument();
        return ob_get_clean();
    }
}