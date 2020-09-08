<?php


namespace booking\repositories;


use booking\entities\Lang;
use booking\entities\message\Dialog;

class DialogRepository
{
    public function get($id)
    {
        if (!$dialog = Dialog::findOne($id)) {
            throw new \DomainException(Lang::t('Диалог не найден'));
        }
        return $dialog;
    }

    public function findByOptional(string $code)
    {
        /*$point = strpos($code, '.');
        $user_id = substr($code, 0, $point - 1);
        $temp = substr($code, $point + 1, strlen($code) - ($point + 1));
        $booking_id = intdiv((int)$temp, 10);
        $typeBooking = (int)$temp % 10;*/

        return Dialog::find()->andWhere(['optional'=>$code])->one();
    }

    public function getSupportUser($user_id)
    {
        return Dialog::find()->andWhere(['user_id'=>$user_id])->andWhere(['typeDialog' => Dialog::CLIENT_SUPPORT])->all();
    }

    public function getSupportAdmin($user_id)
    {
        return Dialog::find()->andWhere(['user_id'=>$user_id])->andWhere(['typeDialog' => Dialog::PROVIDER_SUPPORT])->all();
    }

    public function getAdminByUser($user_id)
    {
        return Dialog::find()->andWhere(['user_id'=>$user_id])->andWhere(['typeDialog' => Dialog::CLIENT_PROVIDER])->all();
    }

    public function getUserByAdmin($admin_id)
    {
        return Dialog::find()->andWhere(['provider_id'=>$admin_id])->andWhere(['typeDialog' => Dialog::CLIENT_PROVIDER])->all();
    }

    public function save(Dialog $dialog)
    {
        if (!$dialog->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения диалога'));
        }
    }
}