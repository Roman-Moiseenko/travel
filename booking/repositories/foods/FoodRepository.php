<?php


namespace booking\repositories\foods;


use booking\entities\foods\Food;
use booking\entities\foods\InfoAddress;
use booking\forms\foods\SearchFoodForm;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\Url;


class FoodRepository
{
    public function get($id): Food
    {
        if (!$result = Food::findOne($id)) {
            throw new \DomainException('Заведение не найдено');
        }
        return $result;
    }


    public function save(Food $food): void
    {
        if (!$food->save()) {
            throw new \DomainException('Заведение не сохранено');
        }
    }

    public function remove(Food $food)
    {
        if (!$food->delete()) {
            throw new \DomainException('Ошибка удаления заведения');
        }
    }

    public function search(SearchFoodForm $form = null): DataProviderInterface
    {
        $query = Food::find()->alias('f')->active('f');

        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['f.created_at' => SORT_ASC], 'desc' => ['f.created_at' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['f.name' => SORT_ASC], 'desc' => ['f.name' => SORT_DESC],
                    ],
                    'rating' => [
                        'asc' => ['f.rating' => SORT_ASC], 'desc' => ['f.rating' => SORT_DESC],
                    ],

                ],
            ],
            'pagination' => [
                'defaultPageSize' => \Yii::$app->params['paginationTour'],
                'pageSizeLimit' => [\Yii::$app->params['paginationTour'], \Yii::$app->params['paginationTour']],
            ],
        ]);
    }

    public function getMap($kitchen_id, $category_id, string $city)
    {
        $foods = Food::find()->alias('f')->active('f');
        if ($kitchen_id != null) {
            $foods = $foods->joinWith('kitchenAssign ka')->andWhere(['ka.kitchen_id' => $kitchen_id]);
        }
        if ($category_id != null) {
            $foods = $foods->joinWith('categoryAssign ca')->andWhere(['ca.category_id' => $category_id]);
        }
        $food_ids = $foods->select('id')->groupBy('id');
        $info = InfoAddress::find()->andWhere(['IN', 'food_id', $food_ids]);
        if ($city != '') {
            $info = $info->andWhere(['city' => $city]);
        }
        $result = array_map(function (InfoAddress $address) {
            return [
                'name' => $address->food->name,
                'phone' => $address->phone,
                'address' => $address->address,
                'latitude' => $address->latitude,
                'longitude' => $address->longitude,
                'photo' => $address->food->mainPhoto->getThumbFileUrl('file', 'map'),
                'link' => Url::to(['/food/view', 'id' => $address->food_id], true),
            ];
        }, $info->all());
        return $result;
    }
}