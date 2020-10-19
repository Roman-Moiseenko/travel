<?php


namespace booking\forms;


use yii\base\Model;

class LangForm extends Model
{
    public $ru;
    public $en;
    public $pl;
    public $de;
    public $fr;
    public $lt;
    public $lv;

    public function rules()
    {
        return [
            [['ru', 'en', 'pl', 'de', 'fr', 'lt', 'lv'], 'string'],
        ];
    }
}