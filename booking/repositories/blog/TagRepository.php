<?php


namespace booking\repositories\blog;


use booking\entities\blog\Tag;
use booking\entities\Lang;

class TagRepository
{
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)) {
            throw new \DomainException(Lang::t('Метка не найдена'));
        }
        return $tag;
    }

    public function save(Tag $tag): void
    {
        if (!$tag->save()) {
            throw new \RuntimeException(Lang::t('Метка не сохранена'));
        }
    }
    public function remove(Tag $tag): void
    {
        if (!$tag->delete()) {
            throw new \RuntimeException(Lang::t('Ошибка удаления метки'));
        }
    }
    public function findByName($name): ?Tag
    {
        return Tag::findOne(['name' => $name]);
    }
}