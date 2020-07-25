<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\Tours;
use booking\entities\booking\tours\Type;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ToursRepository
{
    public function get($id)
    {
        return Tours::findOne($id);
    }

    public function getByUser($user_id)
    {
        return Tours::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Tours::find()->alias('t')->active('t')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Tours $tours)
    {
        if (!$tours->save()) {
            throw new \RuntimeException('Тур не сохранен');
        }
    }

    public function remove(Tours $tours)
    {
        if (!$tours->delete()) {
            throw new \RuntimeException('Ошибка удаления Тура');
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
                            'asc' => ['t.id' => SORT_ASC], 'desc' => ['t.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['t.name' => SORT_ASC], 'desc' => ['t.name' => SORT_DESC],
                        ],
                        /*'price' => [
                            'asc' => ['p.price_new' => SORT_ASC], 'desc' => ['p.price_new' => SORT_DESC],
                        ],*/
                        'rating' => [
                            'asc' => ['t.rating' => SORT_ASC], 'desc' => ['t.rating' => SORT_DESC],
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