<?php


namespace booking\entities\user;


use yii\db\ActiveRecord;

/**
 * Class Preferences
 * @package booking\entities\user
 * @property integer $id
 * @property integer $user_id
 * @property string $lang
 * @property string $currency
 * @property bool $smocking
 *
 */

class Preferences extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%users_preferences}}';
    }
}