<?php


namespace booking\repositories\admin\forum;


use booking\entities\admin\forum\Category;
use booking\entities\admin\forum\Message;
use booking\entities\admin\forum\Post;

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
            throw new \DomainException('Ошибка сохранения.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \DomainException('Ошибка удаления.');
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
        //TODO Возможно сделать в будущем, не работает
        return Message::find()->select('id')->andWhere(
            [
                'IN',
                'post_id',
                Post::find()->andWhere(['category_id' => $id])
            ]
        )->andWhere(
            [
                'created_at' => 'MAX(created_at)'
            ]);

    }
}