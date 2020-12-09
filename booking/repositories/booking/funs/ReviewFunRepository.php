<?php


namespace booking\repositories\booking\funs;

use booking\entities\booking\funs\ReviewFun;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ReviewFunRepository
{

    public function getByFun($fun_id): array
    {
        return ReviewFun::find()->andWhere(['fun_id'=>$fun_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function get($id): ReviewFun
    {
        if (!$review = ReviewFun::findOne($id)) {
            throw new \DomainException('Отзыв не найден');
        }
        return $review;
    }

    public function save(ReviewFun $review): void
    {
        if (!$review->save()) {
            throw new \RuntimeException('Отзыв не сохранен');
        }
    }

    public function remove(ReviewFun $review)
    {
        if (!$review->delete()) {
            throw new \RuntimeException('Ошибка удаления Отзыва');
        }
    }


    public function getAllByFun($fun_id): DataProviderInterface
    {
        $query = ReviewFun::find()->andWhere(['fun_id' => $fun_id]);
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