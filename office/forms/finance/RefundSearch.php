<?php


namespace office\forms\finance;


use booking\entities\finance\Refund;
use yii\data\ActiveDataProvider;

class RefundSearch extends Refund
{

    public function search($params)
    {
        $query = Refund::find()->andWhere(['status' => Refund::STATUS_NEW]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
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