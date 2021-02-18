<?php


namespace booking\repositories\message;


use booking\entities\message\ThemeDialog;

class ThemeDialogRepository
{
    public function get($id): ThemeDialog
    {
        if (!$result = ThemeDialog::findOne($id)) {
            throw new \DomainException('Не найдена тема диалога ' . $id);
        }
        return $result;
    }

    public function save(ThemeDialog $theme): void
    {
        if (!$theme->save()) {
            throw new \DomainException('Тема диалога не сохранена');
        }
    }

    public function remove(ThemeDialog $theme)
    {
        if (!$theme->delete()) {
            throw new \DomainException('Ошибка удаления темы диалога');
        }
    }
}