<?php


namespace booking\repositories\booking\trips;

use booking\entities\booking\trips\ReviewTrip;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewTripRepository
{

    public function getByTrip($trip_id): array
    {
        return ReviewTrip::find()->andWhere(['trip_id'=>$trip_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewTrip
    {
        if (!$review = ReviewTrip::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewTrip $review): void
    {
        if (!$review->save()) {
            throw new \DomainException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewTrip $review)
    {
        if (!$review->delete()) {
            throw new \DomainException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByTrip($trip_id): DataProviderInterface
    {
        $query = ReviewTrip::find()->andWhere(['trip_id' => $trip_id]);
        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['created_at' => SORT_DESC],
                    'attributes' => [
                        'created_at' => [
                            'asc' => ['created_at' => SORT_ASC], 'desc' => ['created_at' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['vote' => SORT_ASC], 'desc' => ['vote' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => 15,
                    'pageSizeLimit' => [15, 100],
                ],
            ]
        );
    }
}