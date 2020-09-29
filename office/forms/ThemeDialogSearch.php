<?php


namespace office\forms;


use booking\entities\message\ThemeDialog;
use yii\data\ActiveDataProvider;

class ThemeDialogSearch extends ThemeDialog
{
    public function rules()
    {
        return [
            [['id', 'type_dialog'], 'integer'],
            [['caption'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = ThemeDialog::find()->andWhere(['!=', 'type_dialog', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['caption' => SORT_ASC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'type_dialog' => $this->type_dialog,
        ]);
        $query
            ->andFilterWhere(['like', 'caption', $this->caption]);
        return $dataProvider;
    }
}