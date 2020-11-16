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
    const DEFAULT = 'ru';

    public static function default(): bool
    {
        return self::current() == self::DEFAULT;
    }

    public static function current(): string
    {
        //scr::v(\Yii::$app->request->cookies->get('lang'));
        //if ($cookie = \Yii::$app->request->cookies->get('lang')) return $cookie->value;
        //Если гость
        if (\Yii::$app->user->isGuest) {
            //Если первоначально сохранение языка уже было в Request
            if (!empty(\Yii::$app->language)) return self::l_()[\Yii::$app->language];

            //Если сохранение языка уже было в куки
            if ($cookie = \Yii::$app->request->cookies->get('lang')) return $cookie->value;

            $data = \Yii::$app->geo->getData();
            if ($data != null) return strtolower($data['country']);
        } else {
            if (!(\Yii::$app->user->identity instanceof User)) return self::DEFAULT;
            /** @var \booking\entities\user\User $user */
            $user = User::findOne(\Yii::$app->user->id);
            if ($user->preferences == null) {
                $data = \Yii::$app->geo->getData();
                if ($data != null) return $data['country'];
            } else {
                return $user->preferences->lang;
            }
        }
        //return self::l_()[\Yii::$app->language];
        return self::DEFAULT;
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

    public static function duration($text): string
    {
        if (self::current() == self::DEFAULT) return $text;
        $text = str_replace('ч', 'h', $text);
        $text = str_replace('мин', 'min', $text);
        $text = str_replace('сек', 'sec', $text);
        $text = str_replace('д', 'days', $text);
        return $text;
    }

    public static function t($text, $lang = null): string
    {
        //Определяем какой User запросил перевод,
        //если клиент, то получаем текущий язык
        //иначе ставим Русский
        if ($lang == null) {
            if (\Yii::$app->user->identity instanceof admin\User || \Yii::$app->user->identity instanceof office\User) {
                $lang = self::DEFAULT;
            } else {
                $lang = self::current();
            }
        }
        if (!$result = Lang::findOne(['ru' => $text])) {
            Lang::create($text);
            return $text;
        }
        return $result->$lang ?? $text;
    }

    public static function a(array $items, $lang = null): array
    {
        foreach ($items as $key => $item) {
            $items[$key] = Lang::t($item, $lang);
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

    public static function _l(): array
    {
        return [
            'ru' => 'ru-RU', 'en' => 'en-US',
        ];
    }

    public static function l_(): array
    {
        return [
            'ru-RU' => 'ru', 'en-US' => 'en',
        ];
    }

    public static function isset($lang): bool
    {
        return in_array($lang, Lang::listLangs());
    }

    public static function setCurrent($lang): string
    {
        if (!self::isset($lang)) $lang = self::DEFAULT;
        if (\Yii::$app->user->isGuest) {
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
        \Yii::$app->language = self::_l()[$lang];
        return $lang;
    }
}