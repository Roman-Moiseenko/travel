<?php


namespace booking\entities\blog\post;


use booking\entities\Lang;
use booking\services\WaterMarker;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\blog\Category;
use booking\entities\blog\post\queries\PostQuery;
use booking\entities\blog\Tag;
use booking\entities\Meta;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $title_en
 * @property string $description_en
 * @property string $content_en
 * @property string $photo
 * @property integer $status
 * @property integer $comments_count
 * @property integer $public_at
 *
 * @property Category $category
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property Comment[] $comments
 * @property string $meta_json [json]
 *
 * @mixin ImageUploadBehavior
 */
class Post extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $meta;

    public static function create($categoryId, $title, $description, $content, Meta $meta, $title_en, $description_en, $content_en): self
    {
        $post = new static();
        $post->category_id = $categoryId;
        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->meta = $meta;
        $post->status = self::STATUS_DRAFT;
        $post->created_at = time();
        $post->comments_count = 0;

        $post->title_en = $title_en;
        $post->description_en = $description_en;
        $post->content_en = $content_en;
        return $post;
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }

    public function edit($categoryId, $title, $description, $content, Meta $meta, $title_en, $description_en, $content_en): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->meta = $meta;
        $this->updated_at = time();

        $this->title_en = $title_en;
        $this->description_en = $description_en;
        $this->content_en = $content_en;
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
        return $this->meta->title ?: $this->getTitle();
    }

    // Tags

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

    // Comments

    public function addComment($userId, $parentId, $text): Comment
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        if ($parent && !$parent->isActive()) {
            throw new \DomainException('Нельзя добавить комментарий в отключенный комментарий.');
        }
        $comments = $this->comments;
        $comments[] = $comment = Comment::create($userId, $parent ? $parent->id : null, $text);
        $this->updateComments($comments);
        return $comment;
    }

    public function editComment($id, $parentId, $text): void
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->edit($parent ? $parent->id : null, $text);
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Комментарий не найден.');
    }

    public function activateComment($id): void
    {
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->activate();
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Комментарий не найден.');
    }

    public function removeComment($id): void
    {
        $comments = $this->comments;
        foreach ($comments as $i => $comment) {
            if ($comment->isIdEqualTo($id)) {
                if ($this->hasChildren($comment->id)) {
                    $comment->draft();
                } else {
                    unset($comments[$i]);
                }
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Комментарий не найден.');
    }

    public function getComment($id): Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                return $comment;
            }
        }
        throw new \DomainException('Комментарий не найден.');
    }

    private function hasChildren($id): bool
    {
        foreach ($this->comments as $comment) {
            if ($comment->isChildOf($id)) {
                return true;
            }
        }
        return false;
    }

    private function updateComments(array $comments): void
    {
        $this->comments = $comments;
        $this->comments_count = count(array_filter($comments, function (Comment $comment) {
            return $comment->isActive();
        }));
    }

    ##########################

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['post_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function getContent()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->content_en)) ? $this->content : $this->content_en;
    }

    public function getTitle()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->title_en)) ? $this->title : $this->title_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['tagAssignments', 'comments'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 1000, 'height' => 150],
                    'landing_list' => ['width' => 300, 'height' => 400],
                    'widget_list' => ['width' => 228, 'height' => 228],
                    'widget_top' => ['width' => 1000, 'height' => 150],
                    'widget_mobile' => ['width' => 300, 'height' => 100],
                    'widget_bottom' => ['width' => 300, 'height' => 150],
                    'profile' => ['width' => 400, 'height' => 400],
                    'origin' => ['processor' => [new WaterMarker(1024, 768, '@static/files/images/logo-mail.png'), 'process']],
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function tableName()
    {
        return '{{%blog_posts}}';
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }


}