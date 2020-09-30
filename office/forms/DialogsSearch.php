<?php


namespace office\forms;


use booking\entities\message\Dialog;
use yii\data\ActiveDataProvider;

class DialogsSearch extends Dialog
{

    public function rules()
    {
        return [
            [['id', 'user_id', 'provider_id', 'typeDialog', 'theme_id', 'created_at'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Dialog::find()->alias('d');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'd.id' => $this->id,
            'd.typeDialog' => $this->typeDialog,
            'd.theme_id' => $this->theme_id,
            'd.user_id' => $this->user_id,
            'd.provider_id' => $this->provider_id,
        ]);
        return $dataProvider;
    }

}