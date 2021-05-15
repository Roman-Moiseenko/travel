<?php


namespace booking\repositories\moving;


use booking\entities\moving\CategoryFAQ;

class CategoryFAQRepository
{
    public function get($id): CategoryFAQ
    {
        if (!$result = CategoryFAQ::findOne($id)) {
            throw new \DomainException('Не найдена категория ' . $id);
        }
        return $result;
    }

    public function save(CategoryFAQ $type): void
    {
        if (!$type->save()) {
            throw new \DomainException('Категория не сохранена');
        }
    }

    public function remove(CategoryFAQ $type)
    {
        if (!$type->delete()) {
            throw new \DomainException('Ошибка удаления категории');
        }
    }

    public function getMaxSort()
    {
        return CategoryFAQ::find()->max('sort');
    }

    public function getAll()
    {
        return CategoryFAQ::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return CategoryFAQ::find()->min('sort');
    }


    public function find($id):? CategoryFAQ
    {
        return CategoryFAQ::findOne($id);
    }
}