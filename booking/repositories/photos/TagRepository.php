<?php


namespace booking\repositories\photos;



use booking\entities\photos\Tag;

class TagRepository
{
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)) {
            throw new \DomainException('Метка не найдена');
        }
        return $tag;
    }

    public function save(Tag $tag): void
    {
        if (!$tag->save()) {
            throw new \DomainException('Метка не сохранена');
        }
    }
    public function remove(Tag $tag): void
    {
        if (!$tag->delete()) {
            throw new \DomainException('Ошибка удаления метки');
        }
    }

    /** ---------------------------READ------------------ */

    public function findByName($name): ?Tag
    {
        return Tag::findOne(['name' => $name]);
    }

    public function find($id): ?Tag
    {
        return Tag::findOne($id);
    }
    public function findBySlug($slug): ?Tag
    {
        return Tag::findOne(['slug' => $slug]);
    }
}