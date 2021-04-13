<?php

namespace App\Modules\V1\Enum;

abstract class VaccinationInterval
{
    public const AT_BIRTH = 'at_birth';
    public const SIX_WEEKS = 'six_weeks';
    public const TEN_WEEKS = 'ten_weeks';
    public const FOURTEEN_WEEKS = 'fourteen_weeks';
    public const NINE_MONTHS = 'nine_months';
    public const TWELVE_MONTHS = 'twelve_months';
    public const FIFTEEN_MONTHS = 'fifteen_months';
    public const EIGHTEEN_MONTHS = 'eighteen_months';
    public const TWO_YEARS = 'two_years';

    public const VACCINATION_INTERVALS = [
        self::AT_BIRTH,
        self::SIX_WEEKS,
        self::TEN_WEEKS,
        self::FOURTEEN_WEEKS,
        self::NINE_MONTHS,
        self::TWELVE_MONTHS,
        self::FIFTEEN_MONTHS,
        self::EIGHTEEN_MONTHS,
        self::TWO_YEARS
    ];
}
