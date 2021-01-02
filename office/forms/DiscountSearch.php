<?php


namespace office\forms;


use booking\entities\booking\Discount;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;

class DiscountSearch extends Discount
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Discount::find()->andWhere(['entities' => \booking\entities\office\User::class]);
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

        return $dataProvider;
    }
}