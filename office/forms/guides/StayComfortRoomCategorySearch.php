<?php


namespace office\forms\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use yii\data\ActiveDataProvider;

class StayComfortRoomCategorySearch extends ComfortRoomCategory
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
        $query = ComfortRoomCategory::find();

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
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}