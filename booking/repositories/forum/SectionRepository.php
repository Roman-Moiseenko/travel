<?php


namespace booking\repositories\forum;


use booking\entities\forum\Section;

class SectionRepository
{
    public function get($id): Section
    {
        if (!$result = Section::findOne($id)) {
            throw new \DomainException('Не найден раздел форума ' . $id);
        }
        return $result;
    }

    public function save(Section $type): void
    {
        if (!$type->save()) {
            throw new \DomainException('Раздел форума не сохранен');
        }
    }

    public function remove(Section $type)
    {
        if (!$type->delete()) {
            throw new \DomainException('Ошибка удаления раздела форума');
        }
    }

    public function getMaxSort()
    {
        return Section::find()->max('sort');
    }

    public function getAll()
    {
        return Section::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return Section::find()->min('sort');
    }

    public function findBySlug($slug)
    {
        return Section::find()->andWhere(['slug' => $slug])->one();
    }

    public function find($id):? Section
    {
        return Section::findOne($id);
    }
}