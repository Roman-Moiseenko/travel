<?php


namespace booking\services\booking\cars;


use booking\entities\booking\cars\SellingCar;
use booking\repositories\booking\cars\SellingCarRepository;

class SellingCarService
{

    /**
     * @var SellingCarRepository
     */
    private $sellingCars;

    public function __construct(SellingCarRepository $sellingCars)
    {
        $this->sellingCars = $sellingCars;
    }

    public function create($calendar_id, $count)
    {
        $selling = SellingCar::create($calendar_id, $count);
        if ($selling->calendar->free() < $count) return false;
        $this->sellingCars->save($selling);
        return $selling;
    }

    public function remove($id)
    {
        $selling = $this->sellingCars->get($id);
        $this->sellingCars->remove($selling);
        return true;
    }
}