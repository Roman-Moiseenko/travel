<?php


namespace booking\services\booking\stays;


use booking\entities\booking\stays\SellingStay;
use booking\repositories\booking\stays\SellingStayRepository;

class SellingStayService
{


    /**
     * @var SellingStayRepository
     */
    private $sellingStays;

    public function __construct(SellingStayRepository $sellingStays)
    {
        $this->sellingStays = $sellingStays;
    }

    public function create($calendar_id, $count)
    {
        $selling = SellingStay::create($calendar_id, $count);
        if ($selling->calendar->free() < $count) return false;
        $this->sellingStays->save($selling);
        return $selling;
    }

    public function remove($id)
    {
        $selling = $this->sellingStays->get($id);
        $this->sellingStays->remove($selling);
        return true;
    }
}