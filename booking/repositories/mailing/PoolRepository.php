<?php


namespace booking\repositories\mailing;


use booking\entities\mailing\Pool;

class PoolRepository
{
    public function get($id): Pool
    {
        if (!$result = Pool::findOne($id)) {
            throw new \DomainException('Не найден пул сообщения' . $id);
        }
        return $result;
    }

    public function save(Pool $pool): void
    {
        if (!$pool->save()) {
            throw new \DomainException('Пул сообщения не сохранен');
        }
    }

    public function remove(Pool $pool)
    {
        if (!$pool->delete()) {
            throw new \DomainException('Ошибка удаления пула сообщения');
        }
    }
}