<?php


namespace admin\forms\tours;


use booking\entities\booking\tours\Extra;
use booking\entities\booking\tours\Tour;
use booking\services\system\LoginService;
use yii\data\ActiveDataProvider;

class ExtraSearch extends Extra
{
    /**
     * @var LoginService
     */
    private $user_id;

    public function __construct($user_id, $config = [])
    {
        parent::__construct($config);
        $this->user_id = $user_id;
    }

    public function rules()
    {
        return [
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Extra::find()->andWhere(['user_id' => $this->user_id]); //'mainPhoto',

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}