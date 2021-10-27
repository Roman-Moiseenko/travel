<?php


namespace engine\tdfirst;


class gUserRepository
{
    public function get($id): gUser
    {
        if (!$gUsers = gUser::findOne($id)) {
            throw new \DomainException('Игрок ' . $id. ' не найден');
        }
        return $gUsers;
    }

    public function getByUserId(string $user_id): gUser
    {
        return gUser::find()->andWhere(['user_id' => $user_id])->one();
    }

    public function save(gUser $gUsers): void
    {
        if (!$gUsers->save()) {
            throw new \DomainException('Игрок ' . $gUsers->id . ' не сохранен');
        }
    }

    public function remove(gUser $gUsers)
    {
        if (!$gUsers->delete()) {
            throw new \DomainException('Ошибка удаления Игрока  ' . $gUsers->id);
        }
    }

    public function getAll()
    {
        return gUser::find()->all();
    }
}