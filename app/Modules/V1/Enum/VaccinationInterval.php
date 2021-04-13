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
        'at_birth',
        'six_weeks',
        'ten_weeks',
        'fourteen_weeks',
        'nine_months',
        'twelve_months',
        'fifteen_months',
        'eighteen_months',
        'two_years'
    ];
}
