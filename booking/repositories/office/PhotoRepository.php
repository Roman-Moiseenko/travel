<?php


namespace booking\repositories\office;


class PhotoRepository
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

    public function getAltNotEmpty():? array
    {
        return array_merge(
            \booking\entities\booking\tours\Photo::find()->andWhere(['<>', 'alt', ''])->all(),
            \booking\entities\booking\stays\Photo::find()->andWhere(['<>', 'alt', ''])->all(),
            \booking\entities\booking\cars\Photo::find()->andWhere(['<>', 'alt', ''])->all(),
            \booking\entities\booking\funs\Photo::find()->andWhere(['<>', 'alt', ''])->all()
        );
    }
}