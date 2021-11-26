<?php


namespace booking\services\realtor\land;


use booking\entities\Meta;
use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\forms\realtor\land\LandForm;
use booking\repositories\realtor\land\LandRepository;

class LandService
{
    /**
     * @var LandRepository
     */
    private $lands;

    public function __construct(LandRepository $lands)
    {
        $this->lands = $lands;
    }

    public function create(LandForm $form): void
    {
        $land = Land::create($form->name, $form->slug, $form->cost);
        foreach ($form->points as $point) {
            $land->addPoint(Point::create($point->latitude, $point->longitude));
        }
        $this->lands->save($land);
    }

    public function edit($id, LandForm $form): void
    {
        $land = $this->lands->get($id);
        $land->edit($form->name, $form->slug, $form->cost);
        $land->clearPoints();
        foreach ($form->points as $point) {
            $land->addPoint(Point::create($point->latitude, $point->longitude));
        }
        $this->lands->save($land);
    }

    public function create_ajax($name, $slug, $cost, array $coords): Land
    {
        $land = Land::create($name, $slug, $cost);
        foreach ($coords as $point) {
            $land->addPoint(Point::create($point[0], $point[1]));
        }

        $land->setMeta(new Meta());
        $this->lands->save($land);
        return $land;
    }

    public function remove_ajax($id)
    {
        $land = $this->lands->get($id);
        $this->lands->remove($land);
    }

    public function edit_ajax($id, $name, $slug, $cost)
    {
        $land = $this->lands->get($id);
        $land->edit($name, $slug, $cost);
        $this->lands->save($land);
        return $land;
    }
}