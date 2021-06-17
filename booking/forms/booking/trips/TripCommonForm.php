<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\trips\Trip;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property TripTypeForm $types
 */
class TripCommonForm extends CompositeForm
{
    public $name;
    public $description;
    public $slug;

    public $name_en;
    public $description_en;

    public $_trip;

    public function __construct(Trip $trip = null, $config = [])
    {
        if ($trip)
        {
            $this->name = $trip->name;
            $this->slug = $trip->slug;
            $this->description = $trip->description;
            $this->name_en = $trip->name_en;
            $this->description_en = $trip->description_en;


            $this->types = new TripTypeForm($trip);
            $this->_trip = $trip;
        } else {
            $this->types = new TripTypeForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en', 'slug'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
            ['name', 'unique', 'targetClass' => Trip::class, 'filter' => $this->_trip ? ['<>', 'id', $this->_trip->id] : null, 'message' => 'Такое имя уже есть'],

        ];
    }

    protected function internalForms(): array
    {
        return ['types'];
    }
}