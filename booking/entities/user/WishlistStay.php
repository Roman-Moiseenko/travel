<?php


namespace booking\entities\user;

use booking\entities\booking\stays\Stay;
use booking\entities\booking\WishlistItemInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $stay_id
 * @property Stay $stay
 */
class WishlistStay extends ActiveRecord implements WishlistItemInterface
{

    public static function create($stay_id): self
    {
        $wishlist = new static();
        $wishlist->stay_id = $stay_id;
        return $wishlist;
    }

    public function isFor($stay_id): bool
    {
        return $this->stay_id == $stay_id;
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stay_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_stays}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->stay->getName();
    }

    public function getLink(): string
    {
        return Url::to(['stay/view', 'id' => $this->stay_id]);
    }

    public function getPhoto(): string
    {
        return $this->stay->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getId(): string
    {
        return $this->stay_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-stay', 'id' => $this->stay_id]);
    }
}