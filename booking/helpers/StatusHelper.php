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
            self::STATUS_LOCK => Lang::t('Заблокирован'),
            self::STATUS_INACTIVE => Lang::t('Новый'),
            self::STATUS_ACTIVE => Lang::t('Активный'),
            self::STATUS_VERIFY => Lang::t('На модерации'),
            self::STATUS_DRAFT => Lang::t('Черновик'),
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