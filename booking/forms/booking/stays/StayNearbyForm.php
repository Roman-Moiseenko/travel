<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\nearby\Nearby;
use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class StayNearbyForm
 * @package booking\forms\booking\stays
 * @property Nearby[] $nearby
 */

class StayNearbyForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $list_nearby = [];
        $count = NearbyCategory::find()->max('id') * 10 + 10;
        for ($i = 0; $i < $count; $i++) {
            $list_nearby[$i] = new NearbyForm();
        }
        $this->nearby = $list_nearby;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['stay_id', 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['nearby'];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $nearby_list = $this->nearby;
        foreach ($nearby_list as $i => $item) {
            if ($item->name == '') unset($nearby_list[$i]);
        }
        $this->nearby = $nearby_list;
    }
}