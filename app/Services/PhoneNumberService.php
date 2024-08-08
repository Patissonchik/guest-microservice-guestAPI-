<?php

namespace App\Services;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

class PhoneNumberService
{
    protected $phoneUtil;

    public function __construct()
    {
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function getCountryFromPhone($phone)
    {
        try {
            $numberProto = $this->phoneUtil->parse($phone, null);
            $regionCode = $this->phoneUtil->getRegionCodeForNumber($numberProto);

            if ($regionCode) {
                return $regionCode;
            }
        } catch (NumberParseException $e) {
            throw new \InvalidArgumentException('Некорректный номер телефона');
        }

        return 'Unknown';
    }

    //private function getCountryNameByRegionCode($regionCode)
    //{
    //    $regionNames = [
    //        'RU' => 'Russia',
    //        'US' => 'United States',
    //        'GB' => 'United Kingdom',
    //        //Можно добавить для каждой возможной страны
    //    ];
//
    //    return $regionNames[$regionCode] ?? 'Unknown';
    //}
}
