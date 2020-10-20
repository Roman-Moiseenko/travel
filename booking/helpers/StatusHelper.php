<?php


namespace booking\helpers;


use booking\entities\booking\tours\Tour;
use booking\entities\Lang;

class StatusHelper
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_VERIFY = 3;
    const STATUS_DRAFT = 4;

    public static function listStatus(): array
    {
        return [
            self::STATUS_LOCK => 'Заблокирован',
            self::STATUS_INACTIVE => 'Новый',
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_VERIFY => 'На модерации',
            self::STATUS_DRAFT => 'Черновик',
        ];
    }

    public static function statusToString($status): string
    {
        $list = self::listStatus();
        return $list[$status];
    }

    public static function statusToHTML($status): string
    {
        $list = self::listStatus();
        if ($status == self::STATUS_LOCK) return '<span class="badge badge-danger">' . $list[$status] . '</span>';
        if ($status == self::STATUS_INACTIVE) return '<span class="badge badge-primary">' . $list[$status] . '</span>';
        if ($status == self::STATUS_VERIFY) return '<span class="badge badge-warning">' . $list[$status] . '</span>';
        if ($status == self::STATUS_ACTIVE) return '<span class="badge badge-success">' . $list[$status] . '</span>';
        if ($status == self::STATUS_DRAFT) return '<span class="badge badge-secondary">' . $list[$status] . '</span>';

    }
}