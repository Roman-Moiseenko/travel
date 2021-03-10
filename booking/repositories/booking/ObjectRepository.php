<?php


namespace booking\repositories\booking;


class ObjectRepository
{

    public function getAltEmpty():? array
    {
        return array_merge(
            \booking\entities\booking\tours\Photo::find()->andWhere(['alt' => null])->all(),
            \booking\entities\booking\stays\Photo::find()->andWhere(['alt' => null])->all(),
            \booking\entities\booking\cars\Photo::find()->andWhere(['alt' => null])->all(),
            \booking\entities\booking\funs\Photo::find()->andWhere(['alt' => null])->all()
        );
    }
}