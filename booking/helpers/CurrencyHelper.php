<?php


namespace booking\helpers;


use booking\entities\user\User;

class CurrencyHelper
{

    const RUB = 1;
    const USD = 2;
    const EUR = 3;
    const PLN = 4;

    public static function current()
    {
        if (\Yii::$app->user->identity instanceof \booking\entities\admin\User) return self::RUB;
            if (\Yii::$app->user->isGuest) {
            if ($cookie = \Yii::$app->request->cookies->get('currency')) return $cookie->value;
            //  $data =\Yii::$app->geo->getData();
            // if ($data != null) return $data['country'];
        } else {
            /** @var \booking\entities\user\User $user */
            $user = User::findOne(\Yii::$app->user->id);
            if ($user->preferences == null) {
                //$data =\Yii::$app->geo->getData();
                // if ($data != null) return $data['country'];
            } else {
                return $user->preferences->currency;
            }
        }
        return self::RUB;
    }

    public static function cost($cost, $decimal = 0)
    {
        if (empty($cost)) {
            return 'free';
        }
        return number_format($cost, $decimal, '.', ' ') . ' руб.';
    }

    public static function stat($cost, $decimal = 0)
    {
        if (empty($cost)) $cost = 0;
        return number_format($cost, $decimal, '.', ' ') . ' &#8381;';
    }

    public static function get($cost, $free = true)
    {
        if (empty($cost) && $free) {
            return '<span class="badge badge-pill badge-success">free</span>';
        }

        $current = self::current();
        if ($current != self::RUB) {
            $currencies = self::get_currencies();
            switch ($current) {
                case self::USD: $code = 'USD'; break;
                case self::EUR: $code = 'EUR'; break;
                case self::PLN: $code = 'PLN'; break;
                default: $code = 'RUB';
            }
            $cost = $cost / $currencies[$code];
            return number_format($cost, 2, '.', '&#160;') . '&#160;' . self::Currency($current);
        }
        return number_format($cost, 0, '.', '&#160;') . '&#160;' . self::Currency($current);
    }

    public static function listCurrency(): array
    {
        /** Руб, Дол, Евро, Злоты */
        return [
            CurrencyHelper::RUB => '&#8381;',
            CurrencyHelper::USD => '&#36;',
            CurrencyHelper::EUR => '&#8364;',
            CurrencyHelper::PLN => 'z&#x142;'
        ];
    }

    public static function listCurrencyDropDown(): array
    {
        /** Руб, Дол, Евро, Злоты */
        return [
            CurrencyHelper::RUB => 'RUB',
            CurrencyHelper::USD => 'USD',
            CurrencyHelper::EUR => 'EUR',
            CurrencyHelper::PLN => 'PLN'
        ];
    }

    public static function Currency($code): string
    {
        $list = self::listCurrency();
        return $list[$code];
    }
    public static function currentString()
    {
        return self::Currency(self::current());
    }

    private static function get_currencies()
    {
        $xml = simplexml_load_file('http://cbr.ru/scripts/XML_daily.asp');
        $currencies = array();
        foreach ($xml->xpath('//Valute') as $valute) {
            $currencies[(string)$valute->CharCode] = (float)str_replace(',', '.', $valute->Value);
        }
        return $currencies;
    }
}