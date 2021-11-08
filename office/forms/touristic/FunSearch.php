<?php


namespace office\forms\touristic;

use booking\entities\touristic\fun\Fun;
use yii\data\ActiveDataProvider;

class FunSearch extends Fun
{

    public $_categoryId = null;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Fun::find();

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
            'category_id' => $this->category_id,
        ]);
        /*if ($this->category_id) $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);*/
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}