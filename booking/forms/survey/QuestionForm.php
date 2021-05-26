<?php


namespace booking\forms\survey;


use booking\entities\survey\Question;
use booking\entities\survey\Variant;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class QuestionForm
 * @package booking\forms\survey
 */
class QuestionForm extends Model
{

    public $question;

    public function __construct(Question $question = null, $config = [])
    {
        if ($question) {
            $this->question = $question->question;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['question', 'string'],
            ['question', 'required']
        ];
    }

}