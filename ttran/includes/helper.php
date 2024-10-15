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

    public static function getCountryCodeByCountry($country)
    {
        $countryCodes = [
            'Bahrain' => 'bh',
            'Saudi Arabia' => 'sa',
            'Australia' => 'au',
            'Italy' => 'it',
            'USA' => 'us',
            'Spain' => 'es',
            'Monaco' => 'mc',
            'Azerbaijan' => 'az',
            'Canada' => 'ca',
            'UK' => 'gb',
            'Austria' => 'at',
            'France' => 'fr',
            'Hungary' => 'hu',
            'Belgium' => 'be',
            'Netherlands' => 'nl',
            'Singapore' => 'sg',
            'Japan' => 'jp',
            'Mexico' => 'mx',
            'Brazil' => 'br',
            'UAE' => 'ae'
        ];
        $defaultFlag = 'un';

        if (isset($countryCodes[$country])) {
            return $countryCodes[$country];
        } else {
            return $defaultFlag;
        }
    }
}
