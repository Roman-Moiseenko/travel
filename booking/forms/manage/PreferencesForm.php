<?php


namespace booking\forms\manage;


use booking\entities\user\Preferences;
use yii\base\Model;

class PreferencesForm extends Model
{
    public $lang;
    public $currency;
    public $smocking;
    public $stars;
    public $disabled;
    public $newsletter;
    public $notice_dialog;

    public function __construct(Preferences $preferences, $config = [])
    {
        $this->lang = $preferences->lang;
        $this->currency = $preferences->currency;
        $this->smocking = $preferences->smocking;
        $this->stars = $preferences->stars;
        $this->disabled = $preferences->disabled;
        $this->newsletter = $preferences->newsletter;
        $this->notice_dialog = $preferences->notice_dialog;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['lang', 'currency', 'smocking', 'stars', 'disabled', 'newsletter', 'notice_dialog'], 'safe'],
        ];
    }
}