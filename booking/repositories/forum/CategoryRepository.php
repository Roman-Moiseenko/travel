<?php


namespace booking\repositories\forum;


use booking\entities\forum\Category;
use booking\entities\forum\Message;
use booking\entities\forum\Post;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new \DomainException('Категория не найден.');
        }
        return $category;
    }


    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

    public function getAll()
    {
        return Category::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMaxSort()
    {
        return Category::find()->max('sort');
    }

    public function getLast($id)
    {
        return Message::find()->select('id')->andWhere(
            [
                'IN',
                'post_id',
                Post::find()->andWhere(['category_id' => $id])
            ]
        )->andWhere(
            [
                'created_at' => Message::find()->andWhere()->max('created_at')
            ]);

    }
}