<?php


namespace booking\forms\art\event;


use booking\entities\art\event\Event;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesAssignmentForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->main = $event->category_id;
            $this->others = ArrayHelper::getColumn($event->categoriesAssignment, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['main', 'required', 'message' => 'Обязательное поле'],
            ['main', 'integer'],
            ['others', 'each', 'rule' => ['integer']],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->others = array_filter((array)$this->others);
        return parent::beforeValidate();
    }
}