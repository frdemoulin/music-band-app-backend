<?php

namespace App\Service;

class GenericHelper
{
    /**
     * Retourne une chaîne de caractère en formattant son premier caractère en majuscule avec gestion des caractères spéciaux.
     *
     * @return string
     */
    public static function mb_ucfirst(string $string): string
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}
