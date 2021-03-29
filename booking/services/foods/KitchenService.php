<?php


namespace booking\services\foods;


use booking\entities\foods\Kitchen;
use booking\forms\foods\KitchenForm;
use booking\repositories\foods\KitchenRepository;

class KitchenService
{
    /**
     * @var KitchenRepository
     */
    private $kitchens;

    public function __construct(KitchenRepository $kitchens)
    {
        $this->kitchens = $kitchens;
    }

    public function create(KitchenForm $form): Kitchen
    {
        $kitchen = Kitchen::create($form->name);
        $this->kitchens->save($kitchen);
        return $kitchen;
    }

    public function edit($id, KitchenForm $form)
    {
        $kitchen = Kitchen::create($form->name);
        $kitchen->edit($form->name);
        $this->kitchens->save($kitchen);
    }
    public function remove($id): void
    {
        $kitchen = $this->kitchens->get($id);
        $this->kitchens->remove($kitchen);
    }
}