<?php


namespace admin\forms\shops;


use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\entities\shops\products\Product;
use yii\data\ActiveDataProvider;


class OrderSearch extends Order
{

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['current_status', 'delivery_method'], 'integer'],
            [['delivery_address_city'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param $shop_id
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($shop_id, $params)
    {
        $query = Order::find()->andWhere(['shop_id' => $shop_id])->andWhere(['<>', 'current_status', StatusHistory::ORDER_PREPARE]); //'mainPhoto',

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'current_status' => $this->current_status,
        ]);
        $query->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }


}