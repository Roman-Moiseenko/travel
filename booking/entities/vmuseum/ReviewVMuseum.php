<?php

namespace booking\entities\vmuseum;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $created_at
 * @property int $vote
 * @property string $text
 * @property integer $vmuseum_id
 * @property VMuseum $vMuseum
 */
class ReviewVMuseum extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%vmuseum_reviews}}';
    }

    public function getVMuseum(): ActiveQuery
    {
        return $this->hasOne(VMuseum::class, ['id' => 'vmuseum_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['vmuseum/review/index', 'id' => $this->vmuseum_id]),
            'frontend' => Url::to(['vmuseum/view', 'id' => $this->vmuseum_id]),
            'update' => Url::to(['cabinet/review/update-vmuseum', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-vmuseum', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_VMUSEUM;
    }

    public function getName(): string
    {
        return $this->vMuseum->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {

    }

    public function getLegal(): Legal
    {
    }
}