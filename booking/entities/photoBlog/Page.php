<?php
declare(strict_types=1);

namespace booking\entities\photoBlog;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $meta_json
 */
class Page extends ActiveRecord
{

}