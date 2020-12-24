<?php


namespace booking\forms\user;


use booking\entities\Lang;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;
use yii\base\Model;

/**
 * Class FastSignUpForm
 * @package booking\forms\user
 * @property FullNameForm $fullname
 * @property SignupForm $signup
 */
class FastSignUpForm extends CompositeForm
{
    public $phone;
    public $agreement;

    public function __construct($config = [])
    {
        $this->signup = new SignupForm();
        $this->fullname = new FullNameForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['phone', 'string', 'min' => 10, 'max' => 13],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i'],
            [['phone'], 'required', 'message' => Lang::t('Обязательное поле. Формат +КодСтраныЦифры, например +79990001111')],
            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],
        ];
    }

    protected function internalForms(): array
    {
        return ['signup', 'fullname'];
    }
}