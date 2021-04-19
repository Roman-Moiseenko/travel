<?php


namespace booking\repositories\shops;


use booking\entities\shops\AdReviewShop;
use booking\entities\shops\products\ReviewProduct;
use booking\entities\shops\ReviewShop;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewProductRepository
{
    public function getByProduct($shop_id): array
    {
        return ReviewProduct::find()->andWhere(['product_id'=>$shop_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewProduct
    {
        if (!$review = ReviewProduct::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewProduct $review): void
    {
        if (!$review->save()) {
            throw new \DomainException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewProduct $review)
    {
        if (!$review->delete()) {
            throw new \DomainException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByProduct($shop_id): DataProviderInterface
    {
        $query = ReviewShop::find()->andWhere(['product_id' => $shop_id]);
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