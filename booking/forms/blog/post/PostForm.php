<?php


namespace booking\forms\blog\post;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use booking\forms\blog\post\TagsForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property MetaForm $meta
 * @property TagsForm $tags
 */

class PostForm extends CompositeForm
{
    public $categoryId;
    public $title;
    public $description;
    public $content;
    public $photo;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->categoryId = $post->category_id;
            $this->title = $post->title;
            $this->description = $post->description;
            $this->content = $post->content;
            $this->meta = new MetaForm($post->meta);
            $this->tags = new TagsForm($post);
        } else {
            $this->meta = new MetaForm();
            $this->tags = new TagsForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['categoryId', 'title'], 'required', 'message' => 'Обязательное поле'],
            [['title'], 'string', 'max' => 255],
            [['categoryId'], 'integer'],
            [['description', 'content'], 'string'],
            [['photo'], 'image'],
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['meta', 'tags'];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}