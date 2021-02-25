<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\Rules;
use yii\base\Model;

class ParkingForm extends Model
{
    public $status; //нет, бесплатна, платна
    public $private; //выделаная или на общем месте
    public $inside; //на территории
    public $reserve; ////возможность забронировать
    public $cost; //цена
    public $cost_type; //час, сутки, месяц, за все время
    public $security; //охраняемая
    public $covered;//крытая
    public $street;//уличная
    public $invalid; //Парковочные места для людей с ограниченными физическими возможностями
    public function __construct(Parking $parking, $config = [])
    {
        $this->status = $parking->status;
        $this->private = $parking->private;
        $this->inside = $parking->inside;
        $this->reserve = $parking->reserve;
        $this->cost = $parking->cost;

        $this->cost_type = $parking->cost_type;
        $this->security = $parking->security;
        $this->covered = $parking->covered;
        $this->street = $parking->street;
        $this->invalid = $parking->invalid;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['private', 'inside', 'reserve', 'security', 'covered', 'street', 'invalid'], 'boolean'],
            [['status', 'cost', 'cost_type'], 'integer'],
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->status == Rules::STATUS_NOT) {
            $this->private = null;
            $this->inside = null;
            $this->reserve = null;
            $this->cost = null;
            $this->cost_type = null;
            $this->security = null;
            $this->covered = null;
            $this->street = null;
            $this->invalid = null;
        }
        if ($this->status == Rules::STATUS_FREE) {
            $this->cost = null;
            $this->cost_type = null;
        }
    }
}