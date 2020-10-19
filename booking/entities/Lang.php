<?php


namespace booking\entities;



use booking\entities\user\User;
use booking\helpers\scr;
use yii\db\ActiveRecord;
use yii\web\Cookie;

/**
 * Class Lang
 * @package booking\entities
 * @property string $ru
 * @property string $en
 * @property string $pl
 * @property string $de
 * @property string $fr
 * @property string $lv
 * @property string $lt
 */
class Lang extends ActiveRecord
{

    public static function current(): string
    {
        if (\Yii::$app->user->isGuest) {
            if ($cookie = \Yii::$app->request->cookies->get('lang')) return $cookie->value;
            $data =\Yii::$app->geo->getData();
            if ($data != null) return $data['country'];
        } else {
            /** @var \booking\entities\user\User $user */
            $user = User::findOne(\Yii::$app->user->id);
            if ($user->preferences == null) {
                $data =\Yii::$app->geo->getData();
                if ($data != null) return $data['country'];
            } else {
                return $user->preferences->lang;
            }
        }
        return 'ru';
    }

    public static function create($text)
    {
        $lang = new static();
        $lang->ru = $text;
        $lang->save();
    }

    public function edit($en, $pl, $de, $fr, $lt, $lv): void
    {
        $this->en = $en;
        $this->pl = $pl;
        $this->de = $de;
        $this->fr = $fr;
        $this->lt = $lt;
        $this->lv = $lv;
    }

    public static function t($text): string
    {
        //Определяем какой User запросил перевод,
        //если клиент, то получаем текущий язык
        //иначе ставим Русский
        if (\Yii::$app->user->identity instanceof admin\User || \Yii::$app->user->identity instanceof office\User) {
            $lang = 'ru';
        } else {
            $lang = Lang::current();
        }

        if (!$result = Lang::findOne(['ru' => $text])) {
            Lang::create($text);
            return $text;
        }
        return $result->$lang ?? $text;
    }

    public static function a(array $items): array
    {
        foreach ($items as $key => $item) {
            $items[$key] = Lang::t($item);
        }
        return $items;
    }

    public static function tableName()
    {
        return '{{%booking_lang}}';
    }

    public static function listLangs(): array
    {
        //TODO Заглушка на языки
        return [
            'ru', 'en',
        ];
        return [
            'ru', 'en', 'pl', 'de', 'fr', 'lt', 'lv'
        ];
    }

    public static function listLangsDropDown(): array
    {
        return [
            'ru' => 'ru', 'en' => 'en',
        ];

        return [
            'ru' => 'ru', 'en' => 'en', 'pl' => 'pl', 'de' => 'de', 'fr' => 'fr', 'lt' => 'lt', 'lv' => 'lv'
        ];
    }

    public static function isset($lang): bool
    {
        return in_array($lang, Lang::listLangs());
    }

    public static function setCurrent($lang)
    {
        $language = $lang;
        if (!self::isset($lang)) return;
        if (\Yii::$app->user->isGuest)
        {
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'lang',
                'value' => $lang,
                'expire' => time() + 3600 * 24 * 365
            ]));
        } else {
            // Сохраняем язык в базе пользователя
            $user = \Yii::$app->user->identity;
            $user->setLang($lang);
            $user->save();
        }
        \Yii::$app->language = $lang;
    }
}