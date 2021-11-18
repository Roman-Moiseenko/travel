<?php


namespace booking\repositories\art\event;


use booking\entities\art\event\Category;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new \DomainException('Категория не найдена');
        }
        return $category;
    }

    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \DomainException('Ошибка сохранения Категории');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \DomainException('Ошибка удаления Категории');
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