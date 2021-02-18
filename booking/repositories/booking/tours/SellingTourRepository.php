<?php


namespace booking\repositories\booking\tours;

use booking\entities\booking\tours\SellingTour;

class SellingTourRepository
{
    public function get($id): SellingTour
    {
        if (!$result = SellingTour::findOne($id)) {
            throw new \DomainException('Не найдена продажа тура ' . $id);
        }
        return $result;
    }

    public function save(SellingTour $selling): void
    {
        if (!$selling->save()) {
            throw new \DomainException('Продажа тура не сохранен');
        }
    }

    public function remove(SellingTour $selling)
    {
        if (!$selling->delete()) {
            throw new \DomainException('Ошибка удаления продажи тура');
        }
    }

    public function getByCalendarId($calendar_id)
    {
        return SellingTour::find()->andWhere(['calendar_id' => $calendar_id])->all();
    }
}