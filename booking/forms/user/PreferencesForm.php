<?php


namespace booking\forms\user;


use booking\entities\user\Preferences;
use booking\entities\user\UserMailing;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property UserMailingForm $user_mailing
 */
class PreferencesForm extends CompositeForm
{
    public $lang;
    public $currency;
    public $smocking;
    public $stars;
    public $disabled;
    //public $newsletter;
    public $notice_dialog;


    public function __construct(Preferences $preferences, UserMailing $mailing, $config = [])
    {
        $this->lang = $preferences->lang;
        $this->currency = $preferences->currency;
        $this->smocking = $preferences->smocking;
        $this->stars = $preferences->stars;
        $this->disabled = $preferences->disabled;
        //$this->newsletter = $preferences->newsletter;
        $this->notice_dialog = $preferences->notice_dialog;
        $this->user_mailing = new UserMailingForm($mailing);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['lang', 'currency', 'smocking', 'stars', 'disabled', 'newsletter', 'notice_dialog'], 'safe'],
        ];
    }

    protected function internalForms(): array
    {
        return ['user_mailing'];
    }
}