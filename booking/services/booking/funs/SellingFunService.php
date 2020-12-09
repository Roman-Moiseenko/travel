<?php


namespace booking\services\booking\funs;


use booking\entities\booking\funs\SellingFun;
use booking\repositories\booking\funs\SellingFunRepository;

class SellingFunService
{

    /**
     * @var SellingFunRepository
     */
    private $sellingFuns;

    public function __construct(SellingFunRepository $sellingFuns)
    {
        $this->sellingFuns = $sellingFuns;
    }

    public function create($calendar_id, $count)
    {
        $selling = SellingFun::create($calendar_id, $count);
        if ($selling->calendar->free() < $count) return false;
        $this->sellingFuns->save($selling);
        return $selling;
    }

    public function remove($id)
    {
        $selling = $this->sellingFuns->get($id);
        $this->sellingFuns->remove($selling);
        return true;
    }
}