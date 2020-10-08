<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\Stay;

class StayRepository
{
    public function getByLegal($legal_id): array
    {
        return [];
        //TODO Заглушка
        return Stay::find()->andWhere(['legal_id' => $legal_id])->all();
    }
}