<?php


namespace booking\repositories\office\guides;


use booking\entities\booking\stays\nearby\NearbyCategory;

class NearbyCategoryRepository
{
    public function get($id): NearbyCategory
    {
        if (!$result = NearbyCategory::findOne($id)) {
            throw new \DomainException('Категория расположения не найдена');
        }
        return $result;
    }

    public function getAll()
    {
        return NearbyCategory::find()->orderBy(['group' => SORT_ASC, 'sort' => SORT_ASC])->all();
    }

    public function save(NearbyCategory $category): void
    {
        if (!$category->save()) {
            throw new \DomainException('Категория расположения не сохранена');
        }
    }

    public function remove(NearbyCategory $category)
    {
        if (!$category->delete()) {
            throw new \DomainException('Ошибка удаления Категории расположения');
        }
    }

    public function getMaxSort($group)
    {
        return NearbyCategory::find()->andWhere(['group' => $group])->max('sort');
    }

    public function getAllByGroup($group)
    {
        return NearbyCategory::find()->andWhere(['group' => $group])->orderBy(['sort' => SORT_ASC])->all();
    }
}