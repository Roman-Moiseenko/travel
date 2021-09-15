<?php


namespace frontend\widgets\templates;


use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use yii\base\Widget;

class GuidesObjectWidget extends Widget
{
    public $object;


    public function run()
    {
        //TODO от класса $object получаем отзывы
        $class = $this->object;
        //Tour::find()->having(['legal_id'])->groupBy(['legal_id'])->all();

        $guides = Legal::find()->where([
            'IN',
            'id',
            Tour::find()->select('legal_id')->groupBy(['legal_id'])
        ])->all();
       /* $guides = array_map(function (Tour $tour) {
            return $tour->legal;
        },
            $class::find()->groupBy(['legal_id'])->all()
        );*/
        return $this->render('guides', [
            'guides' => $guides,
        ]);
    }
}