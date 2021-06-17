<?php

namespace booking\repositories\booking\trips;


use booking\entities\booking\trips\Trip;
use booking\entities\booking\trips\Type;
use booking\entities\Lang;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class TripRepository
{
    public function get($id)
    {
        if (!$result = Trip::findOne($id)) {
            throw new \DomainException('Тур не найден');
        }
        return $result;
    }

    public function getByLegal($legal_id): array
    {
        return Trip::find()->active()->andWhere(['legal_id' => $legal_id])->all();
    }

    public function getByAdminList($user_id)
    {
        return Trip::find()->active()->andWhere(['user_id' => $user_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public function getByUser($user_id)
    {
        return Trip::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function getAllForSitemap()
    {
        return Trip::find()->active()->all();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Trip::find()->alias('t')->active('t');
        return $this->getProvider($query);
    }
/*
    public function search(SearchTripForm $form = null): DataProviderInterface
    {
        $query = Trip::find()->alias('t')->active('t')->with('type', 'mainPhoto');

        return $this->getProvider($query);
    }
*/
    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Trip::find()->alias('t')->active('t')->with('mainPhoto');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Trip $trip)
    {
        if (!$trip->save()) {
            throw new \DomainException('Тур не сохранен');
        }
    }

    public function remove(Trip $trip)
    {
        if (!$trip->delete()) {
            throw new \DomainException('Ошибка удаления Тура');
        }
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['t.public_at' => SORT_ASC], 'desc' => ['t.public_at' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['t.name' => SORT_ASC], 'desc' => ['t.name' => SORT_DESC],
                    ],
                    'date' => [
                        'asc' => ['t.created_at' => SORT_ASC], 'desc' => ['t.created_at' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['t.cost_base' => SORT_ASC], 'desc' => ['t.cost_base' => SORT_DESC],
                    ],
                    'rating' => [
                        'asc' => ['t.rating' => SORT_ASC], 'desc' => ['t.rating' => SORT_DESC],
                    ],

                ],
            ],
            'pagination' => [
                'defaultPageSize' => \Yii::$app->params['paginationTrip'],
                'pageSizeLimit' => [\Yii::$app->params['paginationTrip'], \Yii::$app->params['paginationTrip']],
            ],
        ]);
    }

    public function findBySlug($slug)
    {
        $trip = Trip::find()->andWhere(['slug' => $slug])->one();
        if (empty($trip))
            throw new NotFoundHttpException(Lang::t('Неверный адрес') . ': ' . $slug);
        return $trip;
    }

    public function find($id): ?Trip
    {
        return Trip::findOne($id);
    }

}