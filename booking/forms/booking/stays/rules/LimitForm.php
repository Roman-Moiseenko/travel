<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\rules\Limit;
use yii\base\Model;

class LimitForm extends Model
{
    public $smoking;
    public $animals;
    public $children;
    public $children_allow; //С какого возраста разрешено детям

    public function __construct(Limit $limit, $config = [])
    {
        $this->smoking = $limit->smoking;
        $this->animals = $limit->animals;
        $this->children = $limit->children;
        $this->children_allow = $limit->children_allow;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['smoking', 'children'], 'boolean'],
            [['children_allow', 'animals'], 'integer'],
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if (!$this->children) {
            $this->children_allow = null;
        }
    }
}