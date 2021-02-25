<?php


namespace office\forms\guides;


use booking\entities\booking\City;
use booking\entities\booking\stays\duty\Duty;
use yii\data\ActiveDataProvider;

class DutySearch extends Duty
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
        $query = Duty::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC]
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