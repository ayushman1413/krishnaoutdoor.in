<?php

namespace App\Enums;

enum MediaType: string
{
    case BILLBOARD         = 'BILLBOARD';
    case BUS               = 'BUS';
    case TRAIN             = 'TRAIN';
    case LED               = 'LED';
    case DIGITAL_MARKETING = 'DIGITAL_MARKETING';
    case OTT_PLATFORM      = 'OTT_PLATFORM';
    case OTHER             = 'OTHER';

    public function label(): string {
        if ($this === self::LED) {
            return 'LED';
        }
        if ($this === self::OTT_PLATFORM) {
            return 'OTT Platform';
        }
        return ucwords(str_replace('_', ' ', strtolower($this->name)));
    }
}
