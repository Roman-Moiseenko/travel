<?php


namespace booking\entities\moving;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\entities\queries\CategoryQuery;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use paulzi\nestedsets\NestedSetsBehavior;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $title
 * @property string $photo
 * @property string $slug
 * @property string $content
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 *
 * @property Page $parent
 * @property Page[] $parents
 * @property Page[] $children
 * @property Page $prev
 * @property Page $next
 * @property string $meta_json [json]
 * @property string $icon
 * @property Item[] $items
 * @property string $name [varchar(255)]
 * @mixin NestedSetsBehavior
 * @mixin ImageUploadBehavior
 */
class Page extends ActiveRecord
{
    public $meta;

    public static function create($name, $title, $slug, $content, Meta $meta, $icon): self
    {
        $page = new static();
        $page->title = $title;
        $page->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($title);
        $page->slug = $slug;
        $page->content = $content;
        $page->meta = $meta;
        $page->icon = $icon;
        return $page;
    }

    public function edit($name, $title, $slug, $content, Meta $meta, $icon)
    {
        $this->name = $name;
        $this->title = $title;
        if (empty($slug)) {
            $slug = SlugHelper::slug($title);
        }
        $this->slug = $slug;
        $this->content = $content;
        $this->meta = $meta;
        $this->icon = $icon;
    }
    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }
    public static function tableName()
    {
        return '{{%moving_pages}}';
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'items',
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/moving/pages/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/moving/pages/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/moving/pages/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/moving/pages/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 100],
                    'cart_list' => ['width' => 140, 'height' => 250],
                    'cart_list_2' => ['width' => 140, 'height' => 140],

                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(Item::class, ['page_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function itemMoveUp($item_id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($item_id) && $i != 0) {
                $t1 = $items[$i - 1];
                $t2 = $item;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->items = $items;
                return;
            }
        }
    }

    public function itemMoveDown($item_id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($item_id) && $i != count($items) - 1) {
                $t1 = $item;
                $t2 = $items[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->items = $items;
                return;
            }
        }
    }

    public function itemDelete($item_id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($item_id)) {
                unset($items[$i]);
                $this->items = $items;
                return ;
            }
        }
        throw new \DomainException('Не найден Элемент');
    }

    public function getItem($item_id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($item_id)) {
                return $item;
            }
        }
        throw new \DomainException('Не найден Элемент');
    }

    public function addItem(Item $item): Item
    {
        $items = $this->items;
        $items[] = $item;
        $this->items = $items;
        return $item;
    }

}