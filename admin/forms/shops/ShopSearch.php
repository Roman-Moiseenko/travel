<?php


namespace admin\forms\shops;


use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use yii\data\ActiveDataProvider;


class ShopSearch extends Shop
{

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['type_id', 'status'], 'integer'],
            [['name'], 'safe'],
            ['ad', 'boolean']
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
    public function search($params)
    {
        $query = Shop::find()->andWhere(['user_id' => \Yii::$app->user->id]); //'mainPhoto',

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
            'type_id' => $this->type_id,
            'status' => $this->status,
            'ad' => $this->ad,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }


}