<?php


namespace frontend\widgets\templates;


use yii\base\Widget;

class TagsWidget extends Widget
{
    public $object;

    public function run()
    {
        //TODO от класса $object создаем теги
        //$class = $this->object;
        //ReviewTour::find()->limit(4)->orderBy(['created_at' => SORT_DESC]);
        //$reviews = $class::find()->orderBy(['created_at' => SORT_DESC])->all();
        $tags = [];
        return $this->render('tags', [
            'tags' => $tags,
        ]);
    }
}