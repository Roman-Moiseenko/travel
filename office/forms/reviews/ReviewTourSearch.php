<?php


namespace office\forms\reviews;

use booking\entities\admin\Legal;
use booking\entities\booking\tours\ReviewTour;
use yii\data\ActiveDataProvider;

class ReviewTourSearch extends ReviewTour
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = ReviewTour::find();
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
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
        return $dataProvider;
    }
}