<?php


namespace office\forms;


use booking\entities\Lang;
use yii\data\ActiveDataProvider;

class LangSearch extends Lang
{
    public function rules()
    {
        return [
            [['ru', 'en', 'de', 'pl', 'fr', 'lt', 'lv'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Lang::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['ru' => SORT_ASC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'ru', $this->ru])
            ->andFilterWhere(['like', 'en', $this->en]);
        return $dataProvider;
    }
}