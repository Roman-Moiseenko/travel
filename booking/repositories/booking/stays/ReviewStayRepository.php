<?php


namespace booking\repositories\booking\stays;

use booking\entities\booking\stays\ReviewStay;
use booking\entities\Lang;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewStayRepository
{

    public function get($id): ReviewStay
    {
        if (!$review = ReviewStay::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        return $review;
    }

    public function save(ReviewStay $review): void
    {
        if (!$review->save()) {
            throw new \DomainException(Lang::t('Отзыв не сохранен'));
        }
    }

    public function remove(ReviewStay $review)
    {
        if (!$review->delete()) {
            throw new \DomainException(Lang::t('Ошибка удаления отзыва'));
        }
    }

    public function getAllByStay($stay_id): DataProviderInterface
    {
        $query = ReviewStay::find()->andWhere(['stay_id' => $stay_id]);
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