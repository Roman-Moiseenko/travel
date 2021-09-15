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
        $class = $this->object;
        $guides = Legal::find()->where([
            'IN',
            'id',
            $class::find()->select('legal_id')->groupBy(['legal_id'])
        ])->andWhere(['<>', 'photo', 'NULL'])->all();
        return $this->render('guides', [
            'guides' => $guides,
        ]);
    }
}