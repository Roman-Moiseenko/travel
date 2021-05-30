<?php


namespace booking\services\office;


use booking\entities\office\PriceList;
use booking\forms\office\PriceListForm;
use booking\repositories\office\PriceListRepository;

class PriceListService
{
    /**
     * @var PriceListRepository
     */
    private $repository;

    public function __construct(PriceListRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(PriceListForm $form): PriceList
    {
        $price = PriceList::create($form->key, $form->amount, $form->period, $form->name);
        $this->repository->save($price);
        return $price;
    }

    public function edit($id, PriceListForm $form): void
    {
        $price = $this->repository->get($id);
        $price->edit($form->amount, $form->period);
        $this->repository->save($price);
    }
}