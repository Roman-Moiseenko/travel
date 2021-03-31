<?php


namespace booking\forms\foods;


use yii\base\Model;

class SearchFoodForm extends Model
{
    public $name;
    public $kitchen_id;
    public $category_id;
    public $city;

    public function rules()
    {
        return [
            [['name', 'city'], 'string'],
            [['kitchen_id', 'category_id'], 'integer'],
        ];
    }

}