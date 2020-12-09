<?php


namespace booking\helpers\funs;


use booking\entities\booking\funs\WorkMode;
use booking\entities\Lang;

class WorkModeHelper
{
    const WEEK = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    public static function week(int $i): string
    {
        $week = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        return self::WEEK[$i];
    }

    public static function mode(WorkMode $mode): string
    {
        if (empty($mode->day_begin)) return '<span class="badge badge-danger">Выходной</span>';
        $break = empty($mode->break_begin) ? '<span class="badge badge-success">без обеда</span>' : '<span class="badge badge-warning">обед</span> с ' . $mode->break_begin . ' до ' . $mode->break_end;
        return 'с ' . $mode->day_begin . ' по ' . $mode->day_end . ' ' .  $break;
    }


    public static function weekMode(array $workMode): string
    {
        /** @var $workMode WorkMode[] */
        $result = '';
        foreach (self::WEEK as $i => $day) {
            $result .= '&#160;&#160;&#160;<b>' . Lang::t($day) . '</b> ' . self::mode($workMode[$i]) . '<br>';
        }
        return $result;
    }
}