<?php


namespace office\forms;


use booking\entities\admin\Legal;
use yii\data\ActiveDataProvider;

class LegalsSearch extends Legal
{


    public function rules()
    {
        return [
            [['id', 'created_at'], 'integer'],
            [['name', 'caption'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Legal::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            //'role'
        ]);


        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'caption', $this->caption]);
        return $dataProvider;
    }
}