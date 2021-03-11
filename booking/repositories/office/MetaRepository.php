<?php


namespace booking\repositories\office;


use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;

class MetaRepository
{
    public function getEmptyMeta(): array
    {
        $tours = array_map(function (Tour $model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'description' => $model->description,
                'photo' => $model->mainPhoto->getThumbFileUrl('file', 'admin'),
                'class' => get_class($model),
            ];
        }, Tour::find()->active()->andWhere(['meta_json' => ''])->all());

        $cars = array_map(function (Car $model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'description' => $model->description,
                'photo' => $model->mainPhoto->getThumbFileUrl('file', 'admin'),
                'class' => get_class($model),
            ];
        }, Car::find()->active()->andWhere(['meta_json' => ''])->all());
        $funs = array_map(function (Fun $model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'description' => $model->description,
                'photo' => $model->mainPhoto->getThumbFileUrl('file', 'admin'),
                'class' => get_class($model),
            ];
        }, Fun::find()->active()->andWhere(['meta_json' => ''])->all());
        $stays = array_map(function (Stay $model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'description' => $model->description,
                'photo' => $model->mainPhoto->getThumbFileUrl('file', 'admin'),
                'class' => get_class($model),
            ];
        }, Stay::find()->active()->andWhere(['meta_json' => ''])->all());
        return array_merge($tours, $funs, $cars, $stays);
    }
}