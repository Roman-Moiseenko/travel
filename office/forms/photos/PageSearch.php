<?php


namespace office\forms\photos;

use booking\entities\photos\Page;
use yii\data\ActiveDataProvider;

class PageSearch extends Page
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
            [['title'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Page::find();
        if ($this->verify) $query = $query->verify();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
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
            ->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}