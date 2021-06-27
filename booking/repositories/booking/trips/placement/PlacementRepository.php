<?php

namespace booking\repositories\booking\trips\placement;


use booking\entities\booking\trips\placement\Placement;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;


class PlacementRepository
{
    public function get($id)
    {
        if (!$result = Placement::findOne($id)) {
            throw new \DomainException('Проживание не найдено');
        }
        return $result;
    }

    public function getByUser($user_id)
    {
        return Placement::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function getAll(): DataProviderInterface ///???????
    {
        $query = Placement::find();
        return $this->getProvider($query);
    }

    public function save(Placement $placement)
    {
        if (!$placement->save()) {
            throw new \DomainException('Проживание не сохранено');
        }
    }

    public function remove(Placement $placement)
    {
        if (!$placement->delete()) {
            throw new \DomainException('Ошибка удаления Проживания');
        }
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => \Yii::$app->params['paginationTrip'],
                'pageSizeLimit' => [\Yii::$app->params['paginationTrip'], \Yii::$app->params['paginationTrip']],
            ],
        ]);
    }

}