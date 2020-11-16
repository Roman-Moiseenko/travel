<?php


namespace office\forms\reviews;

use booking\entities\booking\cars\ReviewCar;
use yii\data\ActiveDataProvider;

class ReviewCarSearch extends ReviewCar
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = ReviewCar::find();
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        return $dataProvider;
    }
}