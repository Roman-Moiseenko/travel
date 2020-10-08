<?php


namespace frontend\widgets\legal;


use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use yii\base\Widget;

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

    public function __construct(TourRepository $tours, StayRepository $stays, CarRepository $cars, $config = [])
    {
        parent::__construct($config);
        $this->tours = $tours;
        $this->stays = $stays;
        $this->cars = $cars;
    }


    public function run()
    {
        $tours = $this->tours->getByLegal($this->legal_id);
        $stays = $this->stays->getByLegal($this->legal_id);
        $cars = $this->cars->getByLegal($this->legal_id);

        $obj = array_merge($tours, $stays, $cars);

        return $this->render('objects', [
            'objects' => $obj,
        ]);
    }
}