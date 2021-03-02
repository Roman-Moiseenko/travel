<?php


namespace booking\forms\booking\stays\search;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\Type;
use booking\forms\CompositeForm;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class SearchStayForm
 * @package booking\forms\booking\stays\search
 * @property SearchFieldForm[] $comforts
 * @property SearchFieldForm[] $comforts_room
 * @property SearchFieldForm[] $categories
 */
class SearchStayForm extends CompositeForm
{
    public $date_from;
    public $date_to;

    public $city; //место
    public $guest; //кол-во взрослых
    public $children; //кол-во детей

    public $type; //тип жилья
    public $bedrooms; //кол-во спален
    public $to_center; //до центра

    public $values; //temp

//    public $comfort = [];
//    public $comfort_room = [];
    public $invalid = [];


    public function __construct($config = [])
    {
        $this->values = [];

        $this->comforts = array_map(function (Comfort $comfort) {
                return new SearchFieldForm('comforts', $comfort->id, $comfort->name, false);
            }, Comfort::find()->andWhere(['featured' => true])->all()
        );

        $this->categories = array_map(function (Type $category) {
            return new SearchFieldForm('categories', $category->id, $category->name, false);
        }, Type::find()->orderBy('sort')->all()
        );

        $this->comforts_room = array_map(function (ComfortRoom $comfort) {
            return new SearchFieldForm('comforts_room', $comfort->id, $comfort->name, false);
        }, ComfortRoom::find()->andWhere(['featured' => true])->all()
        );
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type', 'guest', 'children'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
            ['bedrooms', 'integer', 'min' => 0],
            ['to_center', 'integer'],
            ['city', 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['comforts', 'comforts_room', 'categories'];
    }
}