<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\SellingTour;
use booking\repositories\booking\tours\SellingTourRepository;

class SellingTourService
{

    /**
     * @var SellingTourRepository
     */
    private $sellingTours;

    public function __construct(SellingTourRepository $sellingTours)
    {
        $this->sellingTours = $sellingTours;
    }

    public function create($calendar_id, $count)
    {
        $selling = SellingTour::create($calendar_id, $count);
        if ($selling->calendar->free() < $count) return false;
        $this->sellingTours->save($selling);
        return $selling;
    }

    public function remove($id)
    {
        $selling = $this->sellingTours->get($id);
        $this->sellingTours->remove($selling);
        return true;
    }
}