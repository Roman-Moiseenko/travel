<?php


namespace booking\services\booking\stays;


use booking\entities\booking\stays\bedroom\AssignBed;
use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\forms\booking\stays\AssignRoomForm;
use booking\repositories\booking\stays\bedroom\AssignRoomRepository;

class AssignRoomService
{

    /**
     * @var AssignRoomRepository
     */
    private $rooms;

    public function __construct(AssignRoomRepository $rooms)
    {
        $this->rooms = $rooms;
    }

    public function create($stay_id, AssignRoomForm $form, $living = false): AssignRoom
    {
        $sort = 1;
        $room = AssignRoom::create($stay_id, $sort, $living);

        foreach ($form->beds as $bedForm) {
            $room->addBed(
                AssignBed::create($bedForm->bed_id, $bedForm->count)
            );
        }
        $this->rooms->save($room);
        return $room;
    }

    public function edit($id, AssignRoomForm $form): void
    {
        $room = $this->rooms->get($id);
        $room->clearBeds();
        $this->rooms->save($room);
        foreach ($form->beds as $bedForm) {
            $room->addBed(
                AssignBed::create($bedForm->bed_id, $bedForm->count)
            );
        }
        $this->rooms->save($room);
    }

    public function remove($id)
    {
        $room = $this->rooms->get($id);
        $this->rooms->remove($room);
    }
}