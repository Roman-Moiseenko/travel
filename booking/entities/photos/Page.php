<?php
declare(strict_types=1);

namespace booking\entities\photos;

use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\helpers\scr;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

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
        $page->status = self::STATUS_DRAFT;
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
            if ($assignment->isFor($id)) {
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
            if ($assignment->isFor($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Назначение тега не найдено.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    public function addItem(Item $item): void
    {
        $items = $this->items;
        $items[] = $item;
        $this->updateItems($items);
    }

    public function editItem($id, $name, $description, UploadedFile $photo = null): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($id)) {
                $item->edit($name, $description);
                if (!empty($photo)) $item->setPhoto($photo);
                $items[$i] = $item;
                break;
            }
        }
        $this->updateItems($items);
    }

    public function removeItem($id): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($id)) {
                unset($items[$i]);
                break;
            }
        }
        $this->updateItems($items);
    }

    private function updateItems(array $items): void
    {
        /**
         * @var int $i
         * @var Item $item
         */
        foreach ($items as $i => $item) {
            $item->setSort($i);
        }
        $this->items = $items;
    }

    public function moveUpItem($id): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($id) && $i != 0) {
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

    public function moveDownItem($id): void
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isFor($id) && $i != count($items) - 1) {
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


    public static function tableName()
    {
        return '{{%photos_page}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'items',
                    'tagAssignments',
                ]
            ],
        ];
    }

    public function getItem($id): Item
    {
        foreach ($this->items as $item)
        {
            if ($item->isFor($id) == $id) return $item;
        }
        throw new \DomainException('Items не найден id='. $id);
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