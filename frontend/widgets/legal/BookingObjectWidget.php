<?php


namespace frontend\widgets\legal;


use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use yii\base\Widget;
use yii\helpers\Url;

class BookingObjectWidget extends Widget
{
    public $legal_id;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var FunRepository
     */
    private $funs;

    public function __construct(TourRepository $tours, StayRepository $stays, CarRepository $cars, FunRepository $funs, $config = [])
    {
        parent::__construct($config);
        $this->tours = $tours;
        $this->stays = $stays;
        $this->cars = $cars;
        $this->funs = $funs;
    }


    public function run()
    {
        $obj= [];
        $tours = $this->tours->getByLegal($this->legal_id);
        foreach ($tours as $tour) {
            $obj[] = [
                'photo' => $tour->mainPhoto->getThumbFileUrl('file', 'catalog_list'),
                'name' => $tour->getName(),
                'link' => Url::to(['tour/view', 'id' => $tour->id]),
                'description' => $tour->getDescription(),
            ];
        }
        $cars = $this->cars->getByLegal($this->legal_id);
        foreach ($cars as $car) {
            $obj[] = [
                'photo' => $car->mainPhoto->getThumbFileUrl('file', 'catalog_list'),
                'name' => $car->getName(),
                'link' => Url::to(['car/view', 'id' => $car->id]),
                'description' => $car->getDescription(),
            ];
        }
        $funs = $this->funs->getByLegal($this->legal_id);
        foreach ($funs as $fun) {
            $obj[] = [
                'photo' => $fun->mainPhoto->getThumbFileUrl('file', 'catalog_list'),
                'name' => $fun->getName(),
                'link' => Url::to(['fun/view', 'id' => $fun->id]),
                'description' => $fun->getDescription(),
            ];
        }

        $stays = $this->stays->getByLegal($this->legal_id);
        foreach ($stays as $stay) {
            $obj[] = [
                'photo' => $stay->mainPhoto->getThumbFileUrl('file', 'catalog_list'),
                'name' => $stay->getName(),
                'link' => Url::to(['stay/view', 'id' => $stay->id]),
                'description' => $stay->getDescription(),
            ];
        }
      //
        //TODO ** BOOKING_OBJECT **
        shuffle($obj);

        return $this->render('objects', [
            'objects' => $obj,
        ]);
    }
}