<?php


namespace booking\forms\booking\stays\search;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\Type;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use booking\helpers\stays\StayHelper;
use booking\helpers\SysHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class SearchStayForm
 * @package booking\forms\booking\stays\search
 * @property SearchFieldForm[] $comforts      ....
 * @property SearchFieldForm[] $comforts_room      ....
 * @property SearchFieldForm[] $categories      ....
 * @property SearchFieldForm[] $to_center      .... до центра
 * @property SearchFieldForm[] $bedrooms      .... кол-во спален
 */
class SearchStayForm extends CompositeForm
{
    public $date_from;
    public $date_to;

    public $city; //место
    public $guest; //кол-во взрослых
    public $children; //кол-во детей
    public $children_age = [];
    public $invalid = [];

    public $service = [];
    public $stay_id;

    public function __construct($config = [])
    {

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

        $this->to_center = array_map(function ($item) {
            return new SearchFieldForm('to_center', $item[0], $item[1], false);
        }, $this->listToCenter()
        );

        $this->bedrooms = array_map(function ($item) {
            return new SearchFieldForm('bedrooms', $item[0], $item[1], false);
        }, $this->listToBedrooms()
        );

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['guest', 'children', 'stay_id'], 'integer'],
            [['date_from', 'date_to'], 'safe'],
            ['city', 'string'],
            ['children_age', 'each', 'rule' => ['integer']],
            ['service', 'each', 'rule' => ['integer']],
        ];
    }

    protected function internalForms(): array
    {
        return [
            'comforts',
            'comforts_room',
            'categories',
            'to_center',
            'bedrooms',
        ];
    }

    private function listToCenter(): array
    {
        return [
            [1000, 'Менее 1 км'],
            [2000, 'Менее 2 км'],
            [4000, 'Менее 4 км'],
        ];
    }

    private function listToBedrooms(): array
    {
        return [
            [1, 'Одна спальня'],
            [2, 'Две и более'],
            [3, 'Три и более'],
            [4, 'Четыре и более'],
        ];
    }
}