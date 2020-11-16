<?php


namespace booking\forms\booking\cars;


use booking\entities\booking\AgeLimit;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CarParams;
use booking\entities\booking\cars\Characteristic;
use booking\entities\booking\cars\Value;
use booking\forms\booking\AgeLimitForm;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use yii\base\Model;

/**
 * Class ToursParamsForm
 * @package booking\forms\booking\cars
 * @property BookingAddressForm[] $address
 * @property ValueForm[] $values
 * @property AgeLimitForm $ageLimit
 */
class CarParamsForm extends CompositeForm
{
    public $min_rent;
    public $delivery;
    public $license;
    public $experience;

    public function __construct(Car $car, $config = [])
    {
        $this->min_rent = $car->params->min_rent;
        $this->delivery = $car->params->delivery;
        $this->license = $car->params->license;
        $this->experience = $car->params->experience;
        $this->ageLimit = new AgeLimitForm($car->params->age);

        $address = array_map(function (BookingAddress $address) {
            return new BookingAddressForm($address);
        }, $car->address);

        $n = count($address); //Добавляем до 10 точек
        for ($i = 1; $i <= 10 - $n; $i++) {
            $address[] = new BookingAddressForm();
        }
        $this->address = $address;
        $this->values = array_map(function (Characteristic $characteristic) use ($car) {
            return new ValueForm($characteristic, $car->getValue($characteristic->id));
        }, Characteristic::find()->andWhere(['type_car_id' => $car->type_id])->orderBy('sort')->all());

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['min_rent', 'license', 'experience'], 'required', 'message' => 'Обязательное поле'],
            [['min_rent', 'experience'], 'integer'],
            [['license'], 'string'],
            [['delivery'], 'boolean'],

        ];
    }

    protected function internalForms(): array
    {
        return [
            'address',
            'values',
            'ageLimit'];
    }
}