<?php


namespace office\forms;


use booking\entities\admin\Legal;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;

class StaysSearch extends Stay
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
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Stay::find();
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
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}