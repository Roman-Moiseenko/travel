<?php

namespace admin\forms;

use booking\entities\booking\Discount;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ProductSearch represents the model behind the search form of `shop\entities\shop\product\Product`.
 */
class DiscountSearch extends Discount
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'created_at', 'entities_id'], 'integer'],
            [['entities'], 'safe'],
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
        $query = Discount::find()->andWhere(['user_id' => \Yii::$app->user->id]);
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
            'count' => $this->count,
            'entities_id' => $this->entities_id,

        ]);

        return $dataProvider;
    }
}
