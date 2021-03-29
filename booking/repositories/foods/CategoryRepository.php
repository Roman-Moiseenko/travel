<?php


namespace booking\repositories\foods;


use booking\entities\foods\Category;
use booking\entities\foods\Kitchen;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$result = Category::findOne($id)) {
            throw new \DomainException('Категория не найдена');
        }
        return $result;
    }

    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \DomainException('Категория не сохранена');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()) {
            throw new \DomainException('Ошибка удаления категории');
        }
    }
}