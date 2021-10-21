<?php


namespace booking\services\moving;


use booking\entities\moving\agent\Region;
use booking\forms\moving\RegionForm;
use booking\repositories\moving\RegionRepository;

class RegionService
{
    /**
     * @var RegionRepository
     */
    private $regions;

    public function __construct(RegionRepository $regions)
    {
        $this->regions = $regions;
    }

    public function create(RegionForm $form): Region
    {
        $region = Region::create($form->name, $form->link);
        $sort = $this->regions->getMaxSort() + 1;
        $region->setSort($sort);
        $this->regions->save($region);
        return $region;
    }

    public function edit($id, RegionForm $form)
    {
        $region = $this->regions->get($id);
        $region->edit($form->name, $form->link);
        $this->regions->save($region);
    }

    public function remove($id)
    {
        $region = $this->regions->get($id);
        $this->regions->remove($region);
    }

    public function moveUp($id)
    {
        $regions = $this->regions->getAll();
        foreach ($regions as $i => $region) {
            if ($region->isFor($id) && $i != 0) {
                $t1 = $regions[$i - 1];
                $t2 = $region;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->regions->save($t1);
                $this->regions->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $regions = $this->regions->getAll();
        foreach ($regions as $i => $region) {
            if ($region->isFor($id) && $i != count($regions) - 1) {
                $t1 = $region;
                $t2 = $regions[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->regions->save($t1);
                $this->regions->save($t2);
                return;
            }
        }
    }
}