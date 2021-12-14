<?php


namespace booking\repositories\realtor;


use booking\entities\realtor\Landowner;
use booking\helpers\StatusHelper;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class LandownerRepository
{

    public function get($id): Landowner
    {
        if (!$landowner = Landowner::findOne($id)) {
            throw new \DomainException('Участок не найден');
        }
        return $landowner;
    }

    public function save(Landowner $landowner): void
    {
        if (!$landowner->save()) {
            throw new \DomainException('Участок не сохранен');
        }
    }

    public function remove(Landowner $landowner)
    {
        if (!$landowner->delete()) {
            throw new \DomainException('Ошибка удаления Участка');
        }
    }
    /**
     * @return Landowner[]
     */
    public function getAll(): array
    {
        return Landowner::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->orderBy('created_at')->all();
    }


    /**
     * @throws NotFoundHttpException
     */
    public function findBySlug(string $getPathSlug): ?Landowner
    {
        if (!$landowner = Landowner::find()->andWhere(['slug' => $getPathSlug])->one()) throw new NotFoundHttpException('');
        return $landowner;
    }

    public function find($id): Landowner
    {
        return Landowner::find()->andWhere(['id' => $id])->one();
    }

}