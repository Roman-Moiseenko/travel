<?php


namespace booking\forms\booking\funs;

use booking\entities\booking\funs\Characteristic;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\WorkMode;
use booking\forms\booking\AgeLimitForm;
use booking\forms\CompositeForm;

/**
 * Class FunParamsForm
 * @package booking\forms\booking\funs
 * @property AgeLimitForm $ageLimit
 * @property WorkModeForm[] $workModes
 * @property ValueForm[] $values
 */
class FunParamsForm extends CompositeForm
{
    public $annotation;

    public function __construct(Fun $fun, $config = [])
    {
        $this->annotation = $fun->params->annotation;
        $this->workModes = array_map(function (WorkMode $workMode) {
            return new WorkModeForm($workMode);
        }, $fun->params->workMode);
        $this->ageLimit = new AgeLimitForm($fun->params->ageLimit);


        $this->values = array_map(function (Characteristic $characteristic) use ($fun) {
            return new ValueForm($characteristic, $fun->getValue($characteristic->id));
        }, Characteristic::find()->andWhere(['type_fun_id' => $fun->type_id])->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['annotation', 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return [
            'ageLimit',
            'values',
            'workModes',
        ];
    }
}