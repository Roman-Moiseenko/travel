<?php


namespace office\forms;


use booking\entities\admin\Legal;
use yii\data\ActiveDataProvider;

class ProviderLegalSearch extends Legal
{

    public $user_id;

    public function rules()
    {
        return [
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Legal::find()->andWhere(['user_id' => $this->user_id]);
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
        return $dataProvider;
    }
}