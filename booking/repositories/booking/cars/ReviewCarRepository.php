<?php


namespace booking\repositories\booking\cars;

use booking\entities\booking\cars\ReviewCar;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewCarRepository
{
    public function getByCar($car_id): array
    {
        return ReviewCar::find()->andWhere(['car_id'=>$car_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewCar
    {
        if (!$review = ReviewCar::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewCar $review): void
    {
        if (!$review->save()) {
            throw new \DomainException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewCar $review)
    {
        if (!$review->delete()) {
            throw new \DomainException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByCar($car_id): DataProviderInterface
    {
        $query = ReviewCar::find()->andWhere(['car_id' => $car_id]);
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