<?php


namespace booking\forms\survey;


use booking\entities\survey\Survey;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;

/**
 * Class SurveyForm
 * @package booking\forms\survey
 * @property MetaForm $meta
 */

class SurveyForm extends CompositeForm
{
    public $caption;

    public function __construct(Survey $survey = null, $config = [])
    {
        if ($survey) {
            $this->caption = $survey->caption;
            $this->meta = new MetaForm($survey->meta);
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['caption', 'string'],
            ['caption', 'required']
        ];
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }
}