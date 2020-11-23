<?php


namespace booking\repositories\booking\cars;


use booking\entities\booking\cars\SellingCar;

class SellingCarRepository
{
    public function get($id): SellingCar
    {
        if (!$result = SellingCar::findOne($id)) {
            throw new \DomainException('Не найдена продажа авто ' . $id);
        }
        return $result;
    }

    public function save(SellingCar $selling): void
    {
        if (!$selling->save()) {
            throw new \RuntimeException('Продажа авто не сохранен');
        }
    }

    public function remove(SellingCar $selling)
    {
        if (!$selling->delete()) {
            throw new \RuntimeException('Ошибка удаления продажи авто');
        }
    }

    public function getByCalendarId($calendar_id)
    {
        return SellingCar::find()->andWhere(['calendar_id' => $calendar_id])->all();
    }
}