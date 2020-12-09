<?php


namespace booking\repositories\booking\funs;


use booking\entities\booking\funs\SellingFun;

class SellingFunRepository
{
    public function get($id): SellingFun
    {
        if (!$result = SellingFun::findOne($id)) {
            throw new \DomainException('Не найдена продажа билета ' . $id);
        }
        return $result;
    }

    public function save(SellingFun $selling): void
    {
        if (!$selling->save()) {
            throw new \RuntimeException('Продажа билета не сохранен');
        }
    }

    public function remove(SellingFun $selling)
    {
        if (!$selling->delete()) {
            throw new \RuntimeException('Ошибка удаления продажи билета');
        }
    }

    public function getByCalendarId($calendar_id)
    {
        return SellingFun::find()->andWhere(['calendar_id' => $calendar_id])->all();
    }
}