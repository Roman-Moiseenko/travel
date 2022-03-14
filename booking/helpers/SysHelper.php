<?php


namespace booking\helpers;


class SysHelper
{
    public static function isMobile(): bool
    {
        if (!isset($_SERVER["HTTP_USER_AGENT"])) return false;
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public static function orientation($filename)
    {
        $exif = exif_read_data($filename);
        if ($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if ($orientation != 1) {
                $img = imagecreatefromjpeg($filename);
                $deg = 0;
                switch ($orientation) {
                    case 3:
                        $deg = 180;
                        break;
                    case 6:
                        $deg = 270;
                        break;
                    case 8:
                        $deg = 90;
                        break;
                }
                if ($deg) {
                    $img = imagerotate($img, $deg, 0);
                }
                imagejpeg($img, $filename, 80);
            }
        }
    }

    public static function _renderDate($date):? int
    {
        if ($date == null) return null;
        $_arr = [
            'Январь' => 1,
            'Февраль' => 2,
            'Март' => 3,
            'Апрель' => 4,
            'Май' => 5,
            'Июнь' => 6,
            'Июль' => 7,
            'Август' => 8,
            'Сентябрь' => 9,
            'Октябрь' => 10,
            'Ноябрь' => 11,
            'Декабрь' => 12,
        ];
        $_date = mb_substr($date, mb_strpos($date, ',') + 2, mb_strlen($date) - mb_strpos($date, ',') + 2);
        $_date = str_replace(' ', '-', $_date);

        foreach ($_arr as $month => $number)
            if ($_temp = str_replace($month, $number, $_date)) $_date = $_temp;
        //scr::_v($_date);

        return strtotime($_date);
    }

    public static function lazyloaded(string $asRaw)
    {
        $step1 =  preg_replace_callback('/(<img.+\/>)/mx', function ($item) {
            //TODO class="img-responsive" Добавить и протестировать на статьях
            $res = preg_replace('/<img /', '<img loading="lazy" class="img-responsive" ', $item[1]);
        //    $res = preg_replace('/src/', 'data-src', $item[1]);
//            $res = preg_replace('/class="img-responsive"/', 'class="img-responsive lazyloaded"', $res);
            return $res;
        }, $asRaw);

        return $step1;
    }
}