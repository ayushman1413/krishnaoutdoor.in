<?php

namespace App\Enums;

enum ProjectCategory:string
{
    case EDUCATION = "EDUCATION";
    case ENTERTAINMENT = "ENTERTAINMENT";
    case BANKS = "BANKS";
    case BRANDS = "BRANDS";
    // case GAMING = "GAMING";
    // case TECHNOLOGY = "TECHNOLOGY";
    case FMCG = "FMCG";
    case OTHERS = "OTHERS";

    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}
