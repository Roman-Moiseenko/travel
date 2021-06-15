<?php


namespace booking\entities\events;


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
 * @property integer $provider_id
 * @property Provider $provider
 */
class ReviewProvider extends BaseReview
{
    public static function tableName(): string
    {
        return '{{%provider_reviews}}';
    }

    public function getProvider(): ActiveQuery
    {
        return $this->hasOne(Provider::class, ['id' => 'vmuseum_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['provider/review/index', 'id' => $this->provider_id]),
            'frontend' => Url::to(['provider/view', 'id' => $this->provider_id]),
            'update' => Url::to(['cabinet/review/update-provider', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-provider', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_VMUSEUM;
    }

    public function getName(): string
    {
        return $this->provider->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {

    }

    public function getLegal(): Legal
    {
    }
}