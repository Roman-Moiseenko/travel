<?php


namespace booking\repositories\night;


use booking\entities\night\ReviewNight;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewNightRepository
{

    public function getByPage($page_id): array
    {
        return ReviewNight::find()->andWhere(['page_id'=>$page_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewNight
    {
        if (!$review = ReviewNight::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewNight $review): void
    {
        if (!$review->save()) {
            throw new \DomainException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewNight $review)
    {
        if (!$review->delete()) {
            throw new \DomainException('Ошибка удаления Отзыва');
        }
    }

    public function getAllByPage($page_id): DataProviderInterface
    {
        $query = ReviewNight::find()->andWhere(['page_id' => $page_id]);
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