<?php
declare(strict_types=1);

namespace booking\entities\photos;

use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property integer $created_at
 * @property integer $public_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $meta_json
 * @property  Item[] $items
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 */
class Page extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    /** @var $meta Meta */
    public $meta;

    public static function create($user_id, $title, $description, $slug = null): self
    {
        $page = new static();
        $page->user_id = $user_id;
        $page->title = $title;
        $page->slug = $slug ?? SlugHelper::slug($title);
        $page->description = $description;
        $page->created_at = time();
        return $page;
    }

    public function edit($title, $description, $slug = null): void
    {
        $this->title = $title;
        if (empty($slug)) $this->slug = $slug;
        $this->description = $description;
        $this->updated_at = time();
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Пост уже опубликован.');
        }
        $this->public_at = time();
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Пост уже снят с публикации');
        }
        $this->public_at = null;
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public function assignTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Наазначение тега не найдено.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    public function addItem(Item $item): void
    {
        $items = $this->items;
        $items[] = $item;
        $this->items = $items;
    }

    public function editItem($id, Item $item): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                $items[$i] = $item;
                break;
            }
        }
        $this->items = $items;
    }

    public function removeItem($id): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                unset($items[$i]);
                break;
            }
        }
        $this->items = $items;
    }

    public static function tableName()
    {
        return '{{%photos_page}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(Item::class, ['page_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['page_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }
}