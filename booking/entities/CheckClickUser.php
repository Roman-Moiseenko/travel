<?php
declare(strict_types=1);

namespace booking\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $created_at
 * @property string $class_name
 * @property integer $class_id
 * @property integer $type_event
 */

class CheckClickUser extends ActiveRecord
{
    const CLICK_PHONE = '401';
    const CLICK_URL = '402';
    const CLICK_EMAIL = '403';

    public static function create($created_at, $class_name, $class_id, $type_event): self
    {
        $click = new static();
        $click->created_at = $created_at;
        $click->class_name = $class_name;
        $click->class_id = $class_id;
        $click->type_event = $type_event;
        return $click;
    }

    public static function tableName()
    {
        return '{{%check_click_user}}';
    }
}