<?php


namespace booking\repositories\office\guides;


use booking\entities\shops\products\Category;

class ProductCategoryRepository
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
            throw new \DomainException('Saving error.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \DomainException('Removing error.');
        }
    }
}