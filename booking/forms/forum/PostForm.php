<?php


namespace booking\forms\forum;


use booking\forms\forum\MessageForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class PostForm
 * @package booking\forms\forum
 * @property MessageForm $message
 */

class PostForm extends CompositeForm
{
    public $category_id;
    public $caption;

    public function __construct(int $category_id = null, $config = [])
    {
        if ($category_id) $this->category_id = $category_id;
        $this->message = new MessageForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['category_id', 'caption'], 'required', 'message' => 'Обязательное поле'],
            ['category_id', 'integer'],
            ['caption', 'string']
        ];
    }

    protected function internalForms(): array
    {
        return ['message'];
    }
}