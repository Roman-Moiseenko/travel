<?php


namespace booking\services;


class ImageService
{
    public static function rotate($filename)
    {
        try {
            $exif = exif_read_data($filename);
        } catch (\Throwable $e) {
            return;
        }

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
                imagejpeg($img, $filename, 95);
            }
        }
    }
}