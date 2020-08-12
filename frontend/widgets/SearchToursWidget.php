<?php


namespace frontend\widgets;


use booking\forms\booking\tours\SearchToursForm;
use yii\base\Widget;

class SearchToursWidget extends Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {

        $form = new SearchToursForm();
        return $this->render('searchtours', [
            'model' => $form,
        ]);
    }
}