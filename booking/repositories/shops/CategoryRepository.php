<?php


namespace booking\repositories\shops;


use booking\entities\shops\products\Category;
use yii\helpers\ArrayHelper;

class CategoryRepository
{
    public function getRoot(): Category
    {
        return Category::find()->roots()->one();
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->all();
    }

    public function find($id): ?Category
    {
        return Category::find()->andWhere(['id' => $id])->andWhere(['>', 'depth', 0])->one();
    }

    public function getTreeWithSubsOf(Category $category = null, $sub = false): array
    {
        $depth = $sub ? $category->depth : 0;
        $query = Category::find()->andWhere(['>', 'depth', $depth])->orderBy('lft');

        if ($category) {
            $criteria = ['or', ['depth' => 1]];
            foreach (ArrayHelper::merge([$category], $category->parents) as $item) {
                $criteria[] = ['and', ['>', 'lft', $item->lft], ['<', 'rgt', $item->rgt], ['depth' => $item->depth + 1]];
            }
            $query->andWhere($criteria);
        } else {
            $query->andWhere(['depth' => 1]);
        }
        return $query->all();
    }

    public function findBySlug(string $getPathSlug): ?Category
    {
        return Category::find()->andWhere(['slug' => $getPathSlug])->andWhere(['>', 'depth', 0])->one();
    }

}