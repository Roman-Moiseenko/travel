<?php


namespace office\forms\info\events;


use booking\entities\events\Provider;
use booking\entities\foods\Category;
use booking\entities\foods\Food;
use booking\entities\foods\Kitchen;
use yii\data\ActiveDataProvider;

class ProviderSearch extends Provider
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
            ['status', 'integer'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Provider::find()->with(['categoryAssign']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}