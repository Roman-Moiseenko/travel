<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\SellingStay;

class SellingStayRepository
{
    public function get($id): SellingStay
    {
        if (!$result = SellingStay::findOne($id)) {
            throw new \DomainException('Не найдено бронирование ' . $id);
        }
        return $result;
    }

    public function save(SellingStay $selling): void
    {
        if (!$selling->save()) {
            throw new \DomainException('Бронирование не сохранено');
        }
    }

    public function remove(SellingStay $selling)
    {
        if (!$selling->delete()) {
            throw new \DomainException('Ошибка удаления бронирования жилища');
        }
    }

    public function getByCalendarId($calendar_id)
    {
        return SellingStay::find()->andWhere(['calendar_id' => $calendar_id])->all();
    }
}