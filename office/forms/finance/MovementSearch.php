<?php


namespace office\forms\finance;


use booking\entities\finance\Movement;
use booking\entities\finance\Refund;
use yii\data\ActiveDataProvider;

class MovementSearch extends Movement
{

    public function rules()
    {
        return [
            [['user_id', 'legal_id'], 'integer'],
            //['object_class', 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Movement::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
            ],
            'pagination' => [
                'defaultPageSize' => 100,
                'pageSizeLimit' => [100, 100],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'legal_id' => $this->legal_id,
           // 'object_class' => $this->object_class,
        ]);

        return $dataProvider;
    }
}