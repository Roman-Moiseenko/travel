<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\Extra;

class ExtraRepository
{
    public function get($id): Extra
    {
        if (!$result = Extra::find()->andWhere(['id' => $id])->andWhere(['user_id' => \Yii::$app->user->id])->one()) {
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
}