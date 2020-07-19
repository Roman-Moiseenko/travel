<?php


namespace booking\entities\user;


use yii\db\ActiveRecord;

/**
 * Class Preferences
 * @package booking\entities\user
 * @property integer $id
 * @property integer $user_id
 * @property string $lang
 * @property string $currency
 * @property bool $smocking
 *
 */

class Preferences extends ActiveRecord
{
    public static function create($lang = 'ru', $currency = 'руб', $smocking = false)
    {
        $preferences = new static();
        $preferences->lang = $lang;
        $preferences->currency = $currency;
        $preferences->smocking = $smocking;
        return $preferences;
    }
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function edit($lang = 'ru', $currency = 'руб', $smocking = false)
    {

    }

    public static function tableName()
    {
        return '{{%user_preferences}}';
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

}