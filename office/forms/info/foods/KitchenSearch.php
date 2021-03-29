<?php


namespace office\forms\info\foods;


use booking\entities\foods\Kitchen;
use yii\data\ActiveDataProvider;

class KitchenSearch extends Kitchen
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Kitchen::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
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
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}