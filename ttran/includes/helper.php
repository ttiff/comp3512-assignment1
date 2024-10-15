<?php

class Helper
{

    public static function getCountryCodeByNationality($nationality)
    {
        $countryCodes = [
            'Monegasque' => 'mc',
            'Spanish' => 'es',
            'British' => 'gb',
            'Danish' => 'dk',
            'Finnish' => 'fi',
            'French' => 'fr',
            'Japanese' => 'jp',
            'Chinese' => 'cn',
            'German' => 'de',
            'Canadian' => 'ca',
            'Thai' => 'th',
            'Australian' => 'au',
            'Mexican' => 'mx',
            'Dutch' => 'nl',
            'Swiss' => 'ch',
            'Italian' => 'it',
            'American' => 'us',
            'Austrian' => 'at'
        ];


        $defaultFlag = 'un';

        if (isset($countryCodes[$nationality])) {
            return $countryCodes[$nationality];
        } else {
            return $defaultFlag;
        }
    }
}
