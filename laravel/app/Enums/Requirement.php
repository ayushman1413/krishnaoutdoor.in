<?php

namespace App\Enums;

enum Requirement: string
{
    case OUTDOOR = 'OUTDOOR';
    case TRANSIT = 'TRANSIT';
    case DIGITAL = 'DIGITAL';
    case OTT = 'OTT';
    case OTHER = 'OTHER';

    public function label(): string {
        if ($this === self::OTT) {
            return 'OTT';
        }
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}
