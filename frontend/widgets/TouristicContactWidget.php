<?php


namespace frontend\widgets;


use booking\entities\touristic\TouristicContact;
use yii\base\Widget;

class TouristicContactWidget extends Widget
{
    /** @var $contact TouristicContact */
    public $contact;
    public $fun_id;

    public function run()
    {

        return $this->render('touristic_contact', [
            'contact' => $this->contact,
            'fun_id' => $this->fun_id,
        ]);
    }
}