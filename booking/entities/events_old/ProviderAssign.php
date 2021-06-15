<?php


namespace booking\entities\events;


use yii\db\ActiveRecord;

/**
 * Class ProviderAssign
 * @package booking\entities\event
 * @property integer $user_id
 * @property integer $provider_id
 */

class ProviderAssign extends ActiveRecord
{

    public static function create($provider_id): self
    {
        $assign = new static();
        $assign->provider_id = $provider_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->provider_id == $id;
    }

    public static function tableName()
    {
        return '{{%event_users_provider_assign}}';
    }
}