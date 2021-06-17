<?php


namespace admin\widgest;


use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class StatusActionWidget extends Widget
{

    //TODO ** BOOKING_OBJECT **
    public $object_status;
    public $object_id;
    public $object_type;

    public function run()
    {
        switch ($this->object_type) {
            case BookingHelper::BOOKING_TYPE_TOUR:
                $link = '/tour/common';
                break;
            case BookingHelper::BOOKING_TYPE_TRIP:
                $link = '/trip/common';
                break;
            case BookingHelper::BOOKING_TYPE_STAY:
                $link = '/stay/common';
                break;
            case BookingHelper::BOOKING_TYPE_CAR:
                $link = '/car/common';
                break;
            case BookingHelper::BOOKING_TYPE_TICKET:
                $link = '/ticket/common';
                break;
            case BookingHelper::BOOKING_TYPE_FUNS:
                $link = '/fun/common';
                break;
            case BookingHelper::BOOKING_TYPE_HOTEL:
                $link = '/hotel/common';
                break;
            case BookingHelper::BOOKING_TYPE_SHOP:
                $link = '/shop';
                break;
            default:
                throw new \DomainException('Неизвестный тип объекта ' . $this->object_type);
        }
        if ($this->object_status == StatusHelper::STATUS_INACTIVE)
            return Html::a('Отправить на модерацию', Url::to([$link . '/verify', 'id' => $this->object_id]), ['class' => 'btn btn-sm btn-info']);
        if ($this->object_status == StatusHelper::STATUS_VERIFY)
            return Html::a('Отозвать модерацию', Url::to([$link . '/cancel', 'id' => $this->object_id]), ['class' => 'btn btn-sm btn-warning']);
        if ($this->object_status == StatusHelper::STATUS_ACTIVE)
            return Html::a('Снять с публикации', Url::to([$link . '/draft', 'id' => $this->object_id]), ['class' => 'btn btn-sm btn-secondary']);
        if ($this->object_status == StatusHelper::STATUS_DRAFT)
            return Html::a('Опубликовать', Url::to([$link . '/activate', 'id' => $this->object_id]), ['class' => 'btn btn-sm btn-success']);
        if ($this->object_status == StatusHelper::STATUS_LOCK)
            return Html::a('Служба поддержки', Url::to([$link . '/support', 'id' => $this->object_id]), ['class' => 'btn btn-sm btn-light']);
        throw new \DomainException('Неизвестный статус объекта ' . $this->object_status);
    }
}