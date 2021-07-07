<?php


namespace booking\repositories\booking\trips;

use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\Type;

class ActivityRepository
{
    public function get($id): Activity
    {
        if (!$result = Activity::findOne($id)) {
            throw new \DomainException('Не найдена категория тура ' . $id);
        }
        return $result;
    }

    public function save(Activity $activity): void
    {
        if (!$activity->save()) {
            throw new \DomainException('Категория тура не сохранен');
        }
    }

    public function remove(Activity $activity)
    {
        if (!$activity->delete()) {
            throw new \DomainException('Ошибка удаления категории тура');
        }
    }

}