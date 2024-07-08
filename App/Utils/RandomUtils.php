<?php

namespace App\Utils;

final class RandomUtils {
    public static function getUid(int $length = 5):string {
        $bytes = random_bytes($length);
        return substr(bin2hex($bytes), 0, $length);
    }
}

