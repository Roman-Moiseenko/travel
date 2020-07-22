<?php


namespace booking\repositories\booking\rooms;

use booking\entities\booking\rooms\RoomsType;

class RoomsTypeRepository
{
    public function get($id): RoomsType
    {
        if (!$result = RoomsType::findOne('id')) {
            throw new \DomainException('Не найден тип номера ' . $id);
        }
        return $result;
    }

    public function getByStays($staysId): array
    {
        if (!$result = RoomsType::find()->andWhere(['stays_id' => $staysId])->all()) {
            throw new \DomainException('Не найдены по типу жилища ' . $staysId);
        }
        return $result;
    }

    public function save(RoomsType $roomsType): void
    {
        if (!$roomsType->save()) {
            throw new \RuntimeException('Тип номера не сохранен');
        }
    }

    public function remove(RoomsType $roomsType)
    {
        if (!$roomsType->delete()) {
            throw new \RuntimeException('Ошибка удаления типа номера');
        }
    }
}