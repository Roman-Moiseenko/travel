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

    public function getSupportUser($user_id)
    {
        return Dialog::find()->andWhere(['user_id'=>$user_id])->andWhere(['typeDialog' => Dialog::CLIENT_SUPPORT])->all();
    }

    public function save(Dialog $dialog)
    {
        if (!$dialog->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения диалога'));
        }
    }
}