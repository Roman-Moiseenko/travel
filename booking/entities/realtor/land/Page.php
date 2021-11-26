<?php


namespace booking\entities\realtor\land;


use booking\entities\Meta;
use yii\db\ActiveRecord;

/**
 * Class Page
 * @package booking\entities\land
 * @property integer $id
 * @property integer $land_id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $main_photo_id
 * @property string $meta_json
 */
class Page extends ActiveRecord
{
    /** @var $meta Meta */
    public $meta;

    public static function create(): self
    {
        $page = new static();

        return $page;
    }

    public function edit()
    {

    }


    public static function tableName()
    {
        return '{{%land_anonymous_page}}';

    }


}