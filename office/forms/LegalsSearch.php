<?php


namespace office\forms;


use booking\entities\admin\Legal;
use yii\data\ActiveDataProvider;

class LegalsSearch extends Legal
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'caption', 'INN'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Legal::find();
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
            'INN' => $this->INN,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'caption', $this->caption]);
        return $dataProvider;
    }
}