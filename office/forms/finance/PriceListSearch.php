<?php


namespace office\forms\finance;


use booking\entities\office\PriceList;
use yii\data\ActiveDataProvider;

class PriceListSearch extends PriceList
{
    public function rules()
    {
        return [
            ['period', 'integer'],
        ];
    }

    public function search($params)
    {
        $query = PriceList::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
}