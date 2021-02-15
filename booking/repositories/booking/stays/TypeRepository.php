<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\Type;
use booking\entities\Lang;

class TypeRepository
{
    public function get($id): Type
    {
        if (!$result = Type::findOne($id)) {
            throw new \DomainException(Lang::t('Не найден тип жилища') . ' ' . $id);
        }
        return $result;
    }

    public function save(Type $type): void
    {
        if (!$type->save()) {
            throw new \RuntimeException(Lang::t('Тип жилища не сохранен'));
        }
    }

    public function remove(Type $type)
    {
        if (!$type->delete()) {
            throw new \RuntimeException(Lang::t('Ошибка удаления типа жилища'));
        }
    }

    public function getMaxSort()
    {
        return Type::find()->max('sort');
    }

    public function getAll()
    {
        return Type::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return Type::find()->min('sort');
    }

    public function findBySlug($slug)
    {
        return Type::find()->andWhere(['slug' => $slug])->one();
    }

    public function find($id):? Type
    {
        return Type::findOne($id);
    }
}