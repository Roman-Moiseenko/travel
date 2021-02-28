<?php


namespace office\forms\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use yii\data\ActiveDataProvider;

class StayComfortRoomSearch extends ComfortRoom
{
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = ComfortRoom::find();

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
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}