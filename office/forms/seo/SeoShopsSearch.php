<?php


namespace office\forms\seo;


use booking\entities\admin\Legal;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\shops\Shop;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;

class SeoShopsSearch extends Shop
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
        $query = Shop::find()->active();

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