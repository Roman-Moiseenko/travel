<?php
declare(strict_types=1);

namespace booking\helpers;

class SchemaHelper
{
    public static function ArticleUpdate(): string
    {
        return '';
    }

    public static function ToDateJSON(int $date): string
    {
        return date('Y-m-d', $date) . 'T00:00:00+02:00';
    }
}