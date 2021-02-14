<?php


namespace admin\forms;


use booking\entities\admin\Legal;
use booking\entities\booking\tours\stack\Stack;
use yii\data\ActiveDataProvider;

class StackSearch extends Stack
{
    public function rules()
    {
        return [
            ['name', 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Stack::find()->andWhere([
            'IN',
            'legal_id',
            Legal::find()->select('id')->andWhere(['user_id' => \Yii::$app->user->id])
        ]);

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}