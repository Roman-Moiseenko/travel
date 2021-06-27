<?php


namespace booking\repositories\booking\trips\placement;


use booking\entities\booking\trips\placement\room\Room;

class RoomRepository
{
    public function get($id)
    {
        if (!$result = Room::findOne($id)) {
            throw new \DomainException('Номер не найден');
        }
        return $result;
    }

    public function save(Room $room)
    {
        if (!$room->save()) {
            throw new \DomainException('Номер не сохранен');
        }
    }

    public function remove(Room $room)
    {
        if (!$room->delete()) {
            throw new \DomainException('Ошибка удаления Номера');
        }
    }
}