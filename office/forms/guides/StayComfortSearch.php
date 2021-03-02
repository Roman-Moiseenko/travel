<?php


namespace office\forms\guides;


use booking\entities\booking\stays\comfort\Comfort;
use yii\data\ActiveDataProvider;

class StayComfortSearch extends Comfort
{
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name'], 'safe'],
            ['featured', 'boolean'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Comfort::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => 30,

            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'featured' => $this->featured,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}