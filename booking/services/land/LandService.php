<?php


namespace booking\services\land;


use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\forms\land\LandForm;
use booking\helpers\scr;
use booking\repositories\land\LandRepository;

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
        $land = Land::create($form->name, $form->min_price, $form->count);
        foreach ($form->points as $point) {
            $land->addPoint(Point::create($point->latitude, $point->longitude));
        }
        $this->lands->save($land);
    }

    public function edit($id, LandForm $form): void
    {
        $land = $this->lands->get($id);
        $land->edit($form->name, $form->min_price, $form->count);
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