<?php


namespace office\forms;

use booking\entities\booking\funs\Fun;
use booking\entities\shops\Shop;
use yii\data\ActiveDataProvider;

class ShopsSearch extends Shop
{

    public $verify = false;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name'], 'safe'],
            ['ad', 'boolean'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Shop::find();
        if ($this->verify) $query = $query->verify();
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
            'status' => $this->status,
            'ad' => $this->ad,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}