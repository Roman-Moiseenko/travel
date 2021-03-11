<?php


namespace office\forms\seo;


use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;

class SeoToursSearch extends Tour
{

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Tour::find()->active();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}