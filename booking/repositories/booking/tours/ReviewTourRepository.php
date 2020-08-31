<?php


namespace booking\repositories\booking\tours;

use booking\entities\booking\tours\ReviewTour;
use shop\entities\shop\product\Product;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewTourRepository
{

    public function getByTour($tour_id): array
    {
        return ReviewTour::find()->andWhere(['tours_id'=>$tour_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewTour
    {
        if (!$review = ReviewTour::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewTour $review): void
    {
        if (!$review->save()) {
            throw new \RuntimeException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewTour $review)
    {
        if (!$review->delete()) {
            throw new \RuntimeException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByTour($tour_id): DataProviderInterface
    {
        $query = ReviewTour::find()->andWhere(['tours_id' => $tour_id]);
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