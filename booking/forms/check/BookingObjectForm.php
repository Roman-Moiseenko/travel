<?php


namespace booking\forms\check;


use booking\entities\booking\cars\Car;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\tours\TourRepository;
use yii\base\Model;

class BookingObjectForm extends Model
{

    public $objects = [];

    public function __construct(TourRepository $tours, $config = [])
    {
        parent::__construct($config);
    }

    public function list()
    {
        $admin_id = \Yii::$app->user->id;
        $tours = Tour::find()->active()->andWhere(['user_id' => $admin_id])->all();
        $cars = Car::find()->active()->andWhere(['user_id' => $admin_id])->all();
//TODO Заглушка stay funs
        foreach ($tours as $tour) {
            $this->objects[] = ['object_type' => BookingHelper::BOOKING_TYPE_TOUR, 'object_id' => $tour->id];
        }
    }

    public function rules()
    {
        return [
        ['objects', 'each', 'rule' => ['integer']],
    ];
    }
}