<?php


namespace booking\repositories\booking\cars;


use booking\entities\booking\cars\Car;

class CarRepository
{
    public function getByLegal($legal_id): array
    {
        return [];
        //TODO Заглушка
        return Car::find()->andWhere(['legal_id' => $legal_id])->all();
    }
}