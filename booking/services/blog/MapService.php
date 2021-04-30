<?php


namespace booking\services\blog;


use booking\entities\blog\map\Maps;
use booking\entities\blog\map\Point;
use booking\entities\booking\BookingAddress;
use booking\forms\blog\map\MapsForm;
use booking\forms\blog\map\PointForm;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use booking\repositories\blog\MapRepository;

class MapService
{

    /**
     * @var MapRepository
     */
    private $maps;

    public function __construct(MapRepository $maps)
    {
        $this->maps = $maps;
    }

    public function create(MapsForm $form): Maps
    {
        $map = Maps::create($form->name, $form->slug);
        $this->maps->save($map);
        return $map;
    }

    public function edit($id, MapsForm $form): void
    {
        $map = $this->maps->get($id);
        $map->edit($form->name, $form->slug);
        $this->maps->save($map);
    }

    public function remove($id): void
    {
        $map = $this->maps->get($id);
        $this->maps->remove($map);
    }

    public function addPoint($map_id, PointForm $form): void
    {
        $map = $this->maps->get($map_id);
        if ($form->photo->files != null) {
            SysHelper::orientation($form->photo->files[0]->tempName);
        }
        $map->addPoint(Point::create(
            $form->caption,
            $form->link,
            new BookingAddress(
                $form->geo->address,
                $form->geo->latitude,
                $form->geo->longitude),
            $form->photo->files ? $form->photo->files[0] : null,
            ));
        $this->maps->save($map);
    }

    public function editPoint($map_id, $point_id, PointForm $form): void
    {
        $map = $this->maps->get($map_id);

        if ($form->photo->files != null) {
            SysHelper::orientation($form->photo->files[0]->tempName);
        }
        $point = $map->getPoint($point_id);
        $point->save();

        $point->edit(
            $form->caption,
            $form->link,
            new BookingAddress(
                $form->geo->address,
                $form->geo->latitude,
                $form->geo->longitude),
            $form->photo->files ? $form->photo->files[0] : null
        );
    }

    public function removePoint(int $map_id, $id)
    {
        $map = $this->maps->get($map_id);
        $map->removePoint($id);
        $this->maps->save($map);
    }
}