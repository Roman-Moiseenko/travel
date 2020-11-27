<?php


namespace admin\forms\cars;


use booking\entities\booking\cars\Extra;
use yii\data\ActiveDataProvider;

class ExtraSearch extends Extra
{
    public function rules()
    {
        return [
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Extra::find()->andWhere(['user_id' => \Yii::$app->user->id]); //'mainPhoto',

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}