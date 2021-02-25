<?php


namespace office\forms\guides;


use booking\entities\booking\stays\nearby\NearbyCategory;
use yii\data\ActiveDataProvider;

class NearbyCategorySearch extends NearbyCategory
{
    public function rules()
    {
        return [
            ['group', 'integer'],
            [['name' ], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = NearbyCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['group' => SORT_ASC, 'sort' => SORT_ASC]
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
            'group' => $this->group,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}