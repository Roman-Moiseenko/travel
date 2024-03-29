<?php

namespace frontend\widgets;

use booking\repositories\blog\PostRepository;
use yii\base\Widget;

class BlogViewerWidget extends Widget
{
    /**
     * @var PostRepository
     */
    private $posts;
    public $mobile = false;

    public function __construct(PostRepository $posts, $config = [])
    {
        parent::__construct($config);
        $this->posts = $posts;
    }

    public function run()
    {
        $posts = $this->posts->getLast(4);
        return $this->render('blog_viewer', [
            'posts' => $posts,
            'mobile' => $this->mobile
        ]);
    }
}