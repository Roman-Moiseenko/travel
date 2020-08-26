<?php


namespace frontend\widgets;


use booking\helpers\scr;
use yii\base\Widget;

class UserMenuWidget extends Widget
{
    const TOP_USERMENU = 1;
    const CABINET_USERMENU = 2;
    public $type;
    public $class_list;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
       // scr::p($this->type);
        return $this->render('usermenu', [
            'type' =>$this->type,
            'class' =>$this->class_list,
        ]);
    }
}