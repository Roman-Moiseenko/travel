<?php


namespace admin\forms\shops;


use booking\entities\shops\products\Product;
use yii\data\ActiveDataProvider;


class ProductSearch extends Product
{

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['name'], 'safe'],
            [['active'], 'boolean'],
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
        $query = Product::find()->andWhere(['shop_id' => $shop_id]); //'mainPhoto',

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
            'category_id' => $this->category_id,
            'active' => $this->active,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }


}