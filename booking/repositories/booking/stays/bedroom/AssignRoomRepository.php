<?php


namespace booking\repositories\booking\stays\bedroom;


use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\Lang;

class AssignRoomRepository
{
    public function get($id): AssignRoom
    {
        if (!$room = AssignRoom::findOne($id)) {
            throw new \DomainException(Lang::t('Комната не найдена'));
        }
        return $room;
    }

    public function save(AssignRoom $room): void
    {
        if (!$room->save()) {
            throw new \DomainException(Lang::t('Комната не сохранена'));
        }
    }

    public function remove(AssignRoom $room)
    {
        if (!$room->delete()) {
            throw new \DomainException(Lang::t('Ошибка удаления Комнаты'));
        }
    }
}