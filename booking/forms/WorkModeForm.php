<?php


namespace booking\forms;


use booking\entities\booking\funs\WorkMode;
use phpDocumentor\Reflection\Types\False_;
use yii\base\Model;

class WorkModeForm extends Model
{
    public $day_begin;
    public $day_end;
    public $break_begin;
    public $break_end;

    public function __construct(WorkMode $workMode = null, $config = [])
    {
        if ($workMode) {
            $this->day_begin = $workMode->day_begin;
            $this->day_end = $workMode->day_end;
            $this->break_begin = $workMode->break_begin;
            $this->break_end = $workMode->break_end;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['day_begin', 'day_end', 'break_begin', 'break_end'], 'string', 'enableClientValidation' => false],
            //[['day_begin', 'day_end'], 'notEmptyDay', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function beforeValidate()
    {
        if (($this->day_begin != '' && $this->day_end == '') || ($this->day_begin == '' && $this->day_end != '')) {
            \Yii::$app->session->setFlash('error', 'Ошибка заполнения режима дня. Оба поля должны быть заполнены или оба не заполнены');
            return false;
        }
        if (($this->break_begin != '' && $this->break_end == '') || ($this->break_begin == '' && $this->break_end != '')) {
            \Yii::$app->session->setFlash('error', 'Ошибка заполнения обеда. Оба поля должны быть заполнены или оба не заполнены');
            return false;
        }
        return parent::beforeValidate();
    }

}