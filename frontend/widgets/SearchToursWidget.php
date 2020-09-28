<?php


namespace frontend\widgets;


use booking\forms\booking\tours\SearchTourForm;
use yii\base\Widget;

class SearchToursWidget extends Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {

        $form = new SearchTourForm();
        return $this->render('searchtours', [
            'model' => $form,
        ]);
    }
}