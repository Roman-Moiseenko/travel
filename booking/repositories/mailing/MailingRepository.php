<?php


namespace booking\repositories\mailing;


use booking\entities\mailing\Mailing;

class MailingRepository
{
    public function get($id): Mailing
    {
        if (!$result = Mailing::findOne($id)) {
            throw new \DomainException('Не найдена рассылка' . $id);
        }
        return $result;
    }

    public function save(Mailing $mailing): void
    {
        if (!$mailing->save()) {
            throw new \RuntimeException('Рассылка не сохранена');
        }
    }

    public function remove(Mailing $mailing)
    {
        if (!$mailing->delete()) {
            throw new \RuntimeException('Ошибка удаления рассылки');
        }
    }

    public function getLast(int $theme): int
    {
        return Mailing::find()->andWhere(['theme' => $theme])->andWhere(['status' => Mailing::STATUS_SEND])->max('send_at') ?? 0;
    }
}