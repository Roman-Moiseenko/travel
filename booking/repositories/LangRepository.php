<?php


namespace booking\repositories;


use booking\entities\Lang;

class LangRepository
{
    public function get($ru): Lang
    {
        if (!$lang = Lang::findOne(['ru' => $ru])) {
            throw new \DomainException('Строка ' . $ru . ' не найдена.');
        }
        return $lang;
    }

    public function save(Lang $lang): void
    {
        if (!$lang->save()) {
            throw new \RuntimeException('Ошибка сохранения строки Lang.');
        }
    }
    public function remove(Lang $lang): void
    {
        if (!$lang->delete()) {
            throw new \RuntimeException('Ошибка удаления строки Lang.');
        }
    }
}