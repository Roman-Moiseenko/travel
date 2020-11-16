<?php


namespace admin\forms\cars;

use booking\entities\booking\cars\ReviewCar;
use yii\data\ActiveDataProvider;

class ReviewSearch extends ReviewCar
{
    public function rules()
    {
        return [
            [['id', 'cost'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params, $tour_id = null): ActiveDataProvider
    {
        $query = ReviewCar::find()->andWhere(['tour_id' => $tour_id]); //'mainPhoto',

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}