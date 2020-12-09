<?php


namespace admin\forms\funs;

use booking\entities\booking\funs\Extra;
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}