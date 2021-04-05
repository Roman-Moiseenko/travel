<?php


namespace booking\services\office\guides;


use booking\entities\shops\TypeShop;
use booking\forms\office\guides\ShopTypeForm;
use booking\repositories\shops\TypeRepository;

class TypeShopService
{
    private $shopsType;

    public function __construct(TypeRepository $shopsType)
    {
        $this->shopsType = $shopsType;
    }

    public function create(ShopTypeForm $form): TypeShop
    {
        $shopsType = TypeShop::create($form->name, $form->slug);
        $this->shopsType->save($shopsType);
        return $shopsType;
    }

    public function edit($id, ShopTypeForm $form): void
    {
        $shopsType = $this->shopsType->get($id);
        $shopsType->edit($form->name, $form->slug);
        $this->shopsType->save($shopsType);
    }

    public function remove($id): void
    {
        $shopsType = $this->shopsType->get($id);
        $this->shopsType->remove($shopsType);
    }
}