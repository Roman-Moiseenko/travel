<?php


namespace office\forms\reviews;

use booking\entities\admin\Legal;
use booking\entities\booking\stays\ReviewStay;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\foods\ReviewFood;
use booking\entities\shops\ReviewShop;
use yii\data\ActiveDataProvider;

class ReviewShopSearch extends ReviewShop
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = ReviewShop::find();
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