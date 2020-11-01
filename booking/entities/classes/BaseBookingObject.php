<?php


namespace booking\entities\classes;


use booking\entities\admin\Legal;
use booking\entities\booking\BookingAddress;
use yii\db\ActiveRecord;

//TODO Протестировать => удалить или использовать

/**
 * Class Tours
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $name_en
 * @property string $slug
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $main_photo_id
 * @property integer $status
 * @property string $description
 * @property string $description_en
 * @property float $rating
 * @property integer $cancellation
 * @property BookingAddress $address
 * @property bool $pay_bank
 * Оплата через портал или  провайдера
 * @property integer $check_booking
 * @property Legal $legal

 */

class BaseBookingObject extends ActiveRecord
{


}