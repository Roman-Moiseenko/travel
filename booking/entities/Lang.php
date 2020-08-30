<?php


namespace booking\entities;



use booking\entities\user\User;
use booking\helpers\scr;
use yii\db\ActiveRecord;

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

    public static function t($text): string
    {
        //Определяем какой User запросил перевод,
        //если клиент, то получаем текущий язык
        if (\Yii::$app->user->identity instanceof \booking\entities\user\User) {
            $lang = Lang::current();
        }
        //иначе ставим Русский
        if (\Yii::$app->user->identity instanceof \booking\entities\admin\user\User) {
            $lang = 'ru';
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
        return [
            'ru', 'en', 'pl', 'de', 'fr', 'lt', 'lv'
        ];
    }
}