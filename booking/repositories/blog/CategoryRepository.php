<?php


namespace booking\repositories\blog;


use booking\entities\blog\Category;

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
            throw new \DomainException('Saving error.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \DomainException('Removing error.');
        }
    }

    /** ---------------------------READ------------------ */

    public function getAll(): array
    {
        return Category::find()->orderBy('sort')->all();
    }

    public function find($id): ?Category
    {
        return Category::findOne($id);
    }

    public function findBySlug($slug): ?Category
    {
        return Category::find()->andWhere(['slug' => $slug])->one();
    }
}