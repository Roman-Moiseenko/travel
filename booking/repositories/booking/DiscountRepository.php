<?php


namespace booking\repositories\booking;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\Discount;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;

class DiscountRepository
{
    public function get($id): Discount
    {
        if (!$result = Discount::findOne($id)) {
            throw new \DomainException(Lang::t('Скидка на найдена'));
        }
        return $result;
    }

    /** @return BaseBooking[] */
    public function getBookings($id): array
    {
        $tour = BookingTour::find()->andWhere(['discount_id' => $id])->all();
        $car = BookingCar::find()->andWhere(['discount_id' => $id])->all();
        $fun = BookingFun::find()->andWhere(['discount_id' => $id])->all();
        //TODO Заглушка Stay
        $stay = [];
        /*
        $stay = BookingStay::find()->andWhere(['discount_id' => $id])->all();
        */
        return array_merge($tour, $stay, $car, $fun);
    }

    public function find($promo_code, BaseBooking $booking)
    {
        /** @var Discount $discount */
        $discount = Discount::find()->andWhere(['promo' => $promo_code])/*->andWhere(['>', 'count', 0])*/->one();
        if (!$discount) return null;
        //Проверка на остаток
        if ($discount->countNotUsed() == 0)
            throw new \DomainException(Lang::t('Данный промо-код был использован'));
        if ($discount->countNotUsed() < 0)
            throw new \DomainException(Lang::t('Данный промо-код был заблокирован'));
        //Проверка на сущности
        if ($discount->entities == Discount::E_OFFICE_USER) return $discount->id; //Скидка от провайдера
        if ($discount->entities == Discount::E_ADMIN_USER) {
            $admin = $booking->getAdmin();
            if ($admin->id == $discount->entities_id) return $discount->id;
        }
        if ($discount->entities == Discount::E_USER_LEGAL) {
            $legal = $booking->getLegal();
            if ($legal->id == $discount->entities_id) return $discount->id;
        }
        if (get_class($booking) == $discount->entities) {
            if ($discount->entities_id == null && $discount->user_id == $booking->getAdmin()->id) return $discount->id;
            if ($booking->getParentId() == $discount->entities_id) return $discount->id;
        }
        throw new \DomainException(Lang::t('Данный промо-код не подходит к данному бронированию'));
    }

    public function save(Discount $discount): void
    {
        if (!$discount->save()) {
            throw new \DomainException('Скидка не сохранена');
        }
    }

    public function remove(Discount $discount)
    {
        if (!$discount->delete()) {
            throw new \DomainException('Ошибка удаления скидки');
        }
    }
}