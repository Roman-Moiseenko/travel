<?php


namespace booking\repositories\realtor\land;


use booking\entities\realtor\land\Land;
use yii\web\NotFoundHttpException;

class LandRepository
{
    public function get($id): Land
    {
        if (!$result = Land::findOne($id)) {
            throw new \DomainException('Зем.участок не найден');
        }
        return $result;
    }


    public function save(Land $land): void
    {
        if (!$land->save()) {
            throw new \DomainException('Зем.участок не сохранен');
        }
    }

    /**
     * @throws \yii\db\StaleObjectException
     * @throws \Throwable
     */
    public function remove(Land $land)
    {
        if (!$land->delete()) {
            throw new \DomainException('Ошибка удаления зем.участка');
        }
    }

    public function getAll(): array
    {
        return Land::find()->all();
    }

    public function findBySlug($slug):? Land
    {
        if(!$land = Land::find()->andWhere(['slug' => $slug])->one()) throw new NotFoundHttpException('');
        return $land;
    }

    public function find($id):? Land
    {
        return Land::findOne($id);

    }
}