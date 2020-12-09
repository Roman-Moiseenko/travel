<?php


namespace booking\repositories\booking\tours;

use booking\entities\booking\tours\Extra;

class ExtraRepository
{
    public function get($id): Extra
    {
        if (!$result = Extra::findOne($id)) {
            throw new \DomainException('Дополнение на найдено');
        }
        return $result;
    }

    public function getByUser($user_id)
    {
        return Extra::find()->andWhere(['user_id' => $user_id]);
    }

    public function save(Extra $extra): void
    {
        if (!$extra->save()) {
            throw new \RuntimeException('Дополнение не сохранено');
        }
    }

    public function remove(Extra $extra)
    {
        if (!$extra->delete()) {
            throw new \RuntimeException('Ошибка удаления дополнения');
        }
    }

    public function getNextSort($user_id)
    {
        $sort = Extra::find()->andWhere(['user_id' => $user_id])->max('sort');
        return ($sort == null) ? 0 : (int)$sort + 1;
    }
}