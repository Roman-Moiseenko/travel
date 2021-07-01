<?php


namespace booking\helpers;


use booking\entities\user\User;
use booking\entities\forum\Category;
use booking\entities\forum\Post;
use booking\entities\forum\Section;
use yii\helpers\ArrayHelper;

class UserForumHelper
{
    const FORUM_LOCK = '11';
    const FORUM_USER = '21';
    const FORUM_MODERATOR = '31';
    const FORUM_ADMIN = '41';


    public static function listCategory(): array
    {
        return ArrayHelper::map(Category::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(), 'id', 'name');
    }

    public static function listSection(): array
    {
        return ArrayHelper::map(Section::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(), 'id', 'caption');
    }

    public static function isReadCategory($category_id): bool
    {
        $posts = Post::find()->andWhere(['category_id' => $category_id])->all();
        foreach ($posts as $post) {
            if (!self::isReadPost($post->id)) return false;
        }
        return true;
    }

    public static function isReadPost($post_id): bool
    {
        if (\Yii::$app->user->isGuest) return false;
        $user = User::findOne(\Yii::$app->user->id);
        $post = Post::findOne($post_id);
        return $user->isReadForum($post_id, $post->update_at ?? $post->created_at);
    }

    public static function status($forum_role)
    {
        if ($forum_role == self::FORUM_LOCK) return '<span class="badge badge-danger">Заблокирован</span>';
        if ($forum_role == self::FORUM_USER) return '<span class="badge badge-info">Пользователь</span>';
        if ($forum_role == self::FORUM_MODERATOR) return '<span class="badge badge-primary">Модератор</span>';
        if ($forum_role == self::FORUM_ADMIN) return '<span class="badge badge-success">Администратор</span>';
    }

    public static function listStatus(): array
    {
        return [
            self::FORUM_LOCK => 'Заблокирован',
            self::FORUM_USER => 'Пользователь',
            self::FORUM_MODERATOR => 'Модератор',
            self::FORUM_ADMIN => 'Администратор',
        ];
    }

    public static function encodeBB(string $text): string
    {
        //удаляем все теги < >
        $text = strip_tags($text);

        $text = str_replace(PHP_EOL, '<br>', $text);
        $text = preg_replace('/\[(\/?)(b|i|u|s)\s*\]/', "<$1$2>", $text);
       /*
        $text = preg_replace('~\[b\](.+?)\[/b\]~mxi', '<b>$1</b>', $text);
        $text = preg_replace('~\[i\](.+?)\[/i\]~m', '<i>$1</i>', $text);
        $text = preg_replace('~\[u\](.+?)\[/u\]~m', '<u>$1</u>', $text);
        $text = preg_replace('~\[s\](.+?)\[/s\]~m', '<s>$1</s>', $text);*/

        //Картинки и ссылки
        $text = preg_replace('~\[img\](.+?)\[/img\]~s', '<a href="$1" rel="nofollow" target="_blank"><img src="$1" style="max-width: 100px; max-height: 100px"/></a>', $text);
        $text = preg_replace('~\[url=(.+?)\](.+?)\[/url\]~s', '<a href="$1" rel="nofollow" target="_blank">$2</a>', $text);

        //шрифт и цвет

        $text = preg_replace('~\[size=(.+?)\](.+?)\[/size\]~s', '<span style="font-size: $1%">$2</span>', $text);
        $text = preg_replace('~\[color=(.+?)\](.+?)\[/color\]~s', '<span style="color: $1">$2</span>', $text);
        //Список

        $text = preg_replace('~\[\*\](.+?)\[\/\*\]~s', '<li>$1</li>', $text);
        $text = preg_replace('~\[list\](.+?)\[\/list\]~s', '<ul>$1</ul>', $text);
        $text = preg_replace('~\[list=1\](.+?)\[\/list\]~s', '<ol>$1</ol>', $text);

        //Выравнивание
        $text = preg_replace('~\[left\](.+?)\[/left\]~s', '<div style="width: 100%; text-align: left">$1</div>', $text);
        $text = preg_replace('~\[center\](.+?)\[/center\]~s', '<div style="width: 100%; text-align: center">$1</div>', $text);
        $text = preg_replace('~\[right\](.+?)\[/right\]~s', '<div style="width: 100%; text-align: right">$1</div>', $text);
        $text = preg_replace('~\[quote\](.+?)\[/quote\]~s', '<blockquote>$1</blockquote>', $text);
        return $text;

    }
}