<?php


namespace booking\services\booking\stays;


use booking\repositories\booking\stays\StaysTypeRepository;

class StaysTypeService
{
    private $stays;

    public function __construct(StaysTypeRepository $stays)
    {
        $this->stays = $stays;
    }

    public function create(StaysTypeForm $form)
    {

    }
}