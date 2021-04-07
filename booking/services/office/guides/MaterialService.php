<?php


namespace booking\services\office\guides;

use booking\entities\shops\products\Material;
use booking\forms\office\guides\MaterialForm;
use booking\repositories\shops\MaterialRepository;

class MaterialService
{
    private $materials;

    public function __construct(MaterialRepository $materials)
    {
        $this->materials = $materials;
    }

    public function create(MaterialForm $form): Material
    {
        $material = Material::create($form->name);
        $this->materials->save($material);
        return $material;
    }

    public function edit($id, MaterialForm $form): void
    {
        $material = $this->materials->get($id);
        $material->edit($form->name);
        $this->materials->save($material);
    }

    public function remove($id): void
    {
        $material = $this->materials->get($id);
        $this->materials->remove($material);
    }
}