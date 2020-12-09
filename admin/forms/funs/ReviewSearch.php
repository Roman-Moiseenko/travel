<?php


namespace admin\forms\funs;


use booking\entities\booking\funs\ReviewFun;
use yii\data\ActiveDataProvider;

class ReviewSearch extends ReviewFun
{
    public function rules()
    {
        return [
            [['id', 'cost'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params, $fun_id = null): ActiveDataProvider
    {
        $query = ReviewFun::find()->andWhere(['fun_id' => $fun_id]); //'mainPhoto',

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
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}