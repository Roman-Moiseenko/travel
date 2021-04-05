<?php

namespace admin\forms;

use booking\entities\shops\Shop;
use booking\entities\shops\TypeShop;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

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
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Shop::find()->with('type')->andWhere(['user_id' => \Yii::$app->user->id]); //'mainPhoto',

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
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function typeList(): array
    {
        return ArrayHelper::map(TypeShop::find()->
        orderBy('id')->asArray()->all(),
            'id',
            function (array $type) {
                return  $type['name'];
            }
        );
    }

}
