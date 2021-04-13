<?php


namespace booking\forms\shops;


use yii\base\Model;

class CostModalForm extends Model
{
    public $id;
    public $cost;
    public $quantity;
    public $discount;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id', 'cost', 'quantity', 'discount'], 'integer'],
        ];
    }
}