<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\stays\rules\WiFi;
use yii\base\Model;

class WifiForm extends Model
{
    public $status; //нет, бесплатна, платна
    public $area; //выделаная или на общем месте
    public $cost; //цена
    public $cost_type; //час, сутки, месяц, за все время

    public function __construct(WiFi $wiFi, $config = [])
    {
        $this->status = $wiFi->status;
        $this->area = $wiFi->area;
        $this->cost = $wiFi->cost;

        $this->cost_type = $wiFi->cost_type;


        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['status', 'area', 'cost', 'cost_type'], 'integer'],
            [['status', 'area'], 'required', 'message' => 'Необходимо заполнить']
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->status == Rules::STATUS_NOT) {
            $this->area = null;
            $this->cost = null;
            $this->cost_type = null;
        }
        if ($this->status == Rules::STATUS_FREE) {
            $this->cost = null;
            $this->cost_type = null;
        }
    }
}