<?php


namespace booking\entities\moving;


use yii\db\ActiveRecord;

/**
 * Class CloseLink
 * @package booking\entities\moving
 * @property integer $id
 * @property string $link
 * @property string $url
 * @property string $anchor
 */
class CloseLink extends ActiveRecord
{

    public static function create($link, $url, $anchor): self
    {
        $close = new static();
        $close->link = $link;
        $close->url = $url;
        $close->anchor = $anchor;
        return $close;
    }

    public function edit($link, $url, $anchor): self
    {
        $this->link = $link;
        $this->url = $url;
        $this->anchor = $anchor;
    }

    public static function tableName()
    {
        return '{{%moving_close_link}}';
    }
}