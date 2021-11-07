<?php


namespace booking\repositories\touristic\fun;

use booking\entities\touristic\fun\Category;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$result = Category::findOne($id)) {
            throw new \DomainException('Не найдена категория развлечения ' . $id);
        }
        return $result;
    }

    public function save(Category $type): void
    {
        if (!$type->save()) {
            throw new \DomainException('Категория развлечения не сохранен');
        }
    }

    public function remove(Category $type)
    {
        if (!$type->delete()) {
            throw new \DomainException('Ошибка удаления категории развлечения');
        }
    }

    public function getMaxSort()
    {
        return Category::find()->max('sort');
    }

    public function getAll()
    {
        return Category::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return Category::find()->min('sort');
    }

    public function findBySlug($slug)
    {
        return Category::find()->andWhere(['slug' => $slug])->one();
    }

    public function find($id):? Category
    {
        return Category::findOne($id);
    }
}