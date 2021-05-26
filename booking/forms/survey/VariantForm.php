<?php


namespace booking\forms\survey;


use booking\entities\survey\Variant;
use yii\base\Model;

class VariantForm extends Model
{
    public $text;

    public function __construct(Variant $variant = null, $config = [])
    {
        if ($variant) {
            $this->text = $variant->text;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['text', 'string'],
            ['text', 'required'],
        ];
    }
}