<?php

namespace App\Enums;

enum City: string
{
    case AHMEDABAD             = 'Ahmedabad';
    case RAJKOT                = 'Rajkot';
    case BHAVNAGAR             = 'Bhavnagar';
    case JAMNAGAR              = 'Jamnagar';
    case AMRELI                = 'Amreli';
    case ANAND                 = 'Anand';
case SURAT_CITY_BUS        = 'Surat City Bus';
    case BUS_SHELTER_AHMEDABAD = 'Bus Shelter Ahmedabad';
    case CITY_BUS_AHMEDABAD    = 'City Bus Ahmedabad';
    case MUMBAI_TRAIN          = 'Mumbai Train';
    case THANE_CITY_BUS        = 'Thane City Bus';

    public function label(): string
    {
        return $this->value;
    }
}
