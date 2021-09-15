<?php


namespace frontend\widgets\templates;


use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\Lang;
use yii\base\Widget;
use yii\helpers\Url;

class TagsWidget extends Widget
{
    public $object;

    public function run()
    {
        //TODO от класса $object создаем теги
        $tags = [];
        if ($this->object == Tour::class) {
            $tags = array_map(function (Type $type) {
                return ['link' => Url::to(['/tours/category', 'id' => $type->id]), 'caption' =>  $type->name];
            }, Type::find()->all());
        }

        return $this->render('tags', [
            'tags' => $tags,
        ]);
    }
}