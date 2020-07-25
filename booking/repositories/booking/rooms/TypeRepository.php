<?php


namespace booking\repositories\booking\rooms;

use booking\entities\booking\rooms\Type;

class TypeRepository
{
    public function get($id): Type
    {
        if (!$result = Type::findOne('id')) {
            throw new \DomainException('Не найден тип номера ' . $id);
        }
        return $result;
    }

    public function getByStays($staysId): array
    {
        if (!$result = Type::find()->andWhere(['stays_id' => $staysId])->all()) {
            throw new \DomainException('Не найдены по типу жилища ' . $staysId);
        }
        return $result;
    }

    public function save(Type $type): void
    {
        if (!$type->save()) {
            throw new \RuntimeException('Тип номера не сохранен');
        }
    }

    public function remove(Type $type)
    {
        if (!$type->delete()) {
            throw new \RuntimeException('Ошибка удаления типа номера');
        }
    }
}