<?php


namespace booking\repositories\blog;


use booking\entities\blog\map\Maps;
use yii\web\NotFoundHttpException;

class MapRepository
{
    public function get($id): Maps
    {
        if (!$map = Maps::findOne($id)) {
            throw new \DomainException('Карта не найдена.');
        }
        return $map;
    }

    public function save(Maps $map): void
    {
        if (!$map->save()) {
            throw new \DomainException('Ошибка сохранения карты.');
        }
    }

    public function remove(Maps $map): void
    {
        if (!$map->delete()) {
            throw new \DomainException('Ошибка удаления карты.');
        }
    }

    public function getBySlug($slug): Maps
    {
        if (!$map = Maps::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException('Карта не найдена.');
        }
        return $map;
    }
}