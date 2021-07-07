<?php


namespace admin\forms\trips;


use booking\entities\booking\trips\activity\Activity;
use yii\data\ActiveDataProvider;

class ActivitySearch extends Activity
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day'], 'integer'],
            [['time', 'caption'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param $trip_id
     * @return ActiveDataProvider
     */
    public function search($params, $trip_id)
    {
        $query = Activity::find()->andWhere(['trip_id' => $trip_id]); //'mainPhoto',

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
        return ArrayHelper::map(Type::find()->
        orderBy('id')->asArray()->all(),
            'id',
            function (array $type) {
                return  $type['name'];
            }
        );
    }

    public function featured()
    {
        return [false => 'Нет', true => 'Да'];
    }
}