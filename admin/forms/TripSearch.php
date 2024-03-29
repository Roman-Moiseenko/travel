<?php

namespace admin\forms;

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\booking\trips\Trip;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class TripSearch extends Trip
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Trip::find()->andWhere(['user_id' => \Yii::$app->user->id]); //'mainPhoto',

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
            'status' => $this->status,

        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
/*
    public function typeList(): array
    {
        return ArrayHelper::map(Type::find()->
        orderBy('id')->asArray()->all(),
            'id',
            function (array $type) {
                return  $type['name'];
            }
        );
    }*/

    public function featured()
    {
        return [false => 'Нет', true => 'Да'];
    }
}
