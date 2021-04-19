<?php


namespace booking\repositories\shops;


use booking\entities\shops\AdReviewShop;
use booking\entities\shops\ReviewShop;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewShopRepository
{
    public function getByAdShop($shop_id): array
    {
        return ReviewShop::find()->andWhere(['shop_id'=>$shop_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewShop
    {
        if (!$review = ReviewShop::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewShop $review): void
    {
        if (!$review->save()) {
            throw new \DomainException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewShop $review)
    {
        if (!$review->delete()) {
            throw new \DomainException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByShop($shop_id): DataProviderInterface
    {
        $query = ReviewShop::find()->andWhere(['shop_id' => $shop_id]);
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