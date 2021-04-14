<?php

use App\Modules\V1\Enum\VaccinationInterval;
use App\Modules\V1\Models\VaccinationSmsSample;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationSmsSampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_sms_sample', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('interval', VaccinationInterval::VACCINATION_INTERVALS);
            $table->longText('sms');
            $table->enum('language', ['english', 'yoruba', 'hausa', 'igbo']);
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('active_status')->references('id')->on('active_status');
        });

        $at_birth = [
            'english' => 'You have successfully subscribed for our vaccination injection reminder. Your baby is to receive this vaccinations at birth hepatitis B, Oral Polio (OPV) and BCG vaccination.',

            'yoruba' => 'O ti ṣe alabapin si ṣaṣeyọri fun olurannileti abẹrẹ ajesara wa. Ọmọ rẹ ni lati gba awọn oogun yi ni ibimọ ẹdọ-ẹdọ B, Oral Polio (OPV) ati ajesara BCG.',
            
            'igbo' => 'Havedebanyela aha nke ọma maka ihe ncheta ịgba ọgwụ mgbochi anyị. Nwa gị ga-anara ọgwụ mgbochi a mgbe a mụrụ ya ịba ọcha n\'anya B, Oral Polio (OPV) yana ịgba ọgwụ mgbochi BCG.',

            'hausa' => 'Kun sami nasarar yin rajista don tunatarwar allurar mu. Yaronka zai sami wannan rigakafin lokacin haihuwar hepatitis B, Oral Polio (OPV) da kuma allurar BCG.'
        ];

        $six_weeks = [
            'english' => 'This is to inform you that you need to bring your child for OPV, Pentavalent vaccine, rotavirus and Pneumococcal Conjugate (PCV)',

            'yoruba' => 'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun OPV, Pentavalent ajesara, rotavirus ati Pneumococcal Conjugate (PCV)',
            
            'igbo' => 'Nke a bụ iji gwa gị na ịchọrọ ịkpọtara nwa gị maka ọgwụ mgbochi OPV, ọgwụ Pentavalent, rotavirus na Pneumococcal Conjugate (PCV)',

            'hausa' => 'Wannan don sanar da ku cewa kuna buƙatar kawo ɗan ku don OPV, Pentavalent allurar, rotavirus da Pneumococcal Conjugate (PCV)'
        ];

        $ten_weeks = [
            'english' => 'This is to inform you that you need to bring your child for OPV, rotavirus, penta, pcv',

            'yoruba' => 'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ wa fun OPV, rotavirus, penta, pcv',
            
            'igbo' => 'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka OPV, rotavirus, penta, pcv',

            'hausa' => 'Wannan don sanar da ku cewa kuna buƙatar kawo ɗanku don OPV, rotavirus, penta, pcv'
        ];

        $fourteen_weeks = [
            'english' => 'This is to inform you that you need to bring your child for OPV, penta, PCV, inactivated polio vaccine (IPV)',

            'yoruba' => 'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ wa fun OPV, penta, PCV, ajesara aarun ajakalẹ-arun (IPV)',
            
            'igbo' => 'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka OPV, penta, PCV, ọgwụ mgbochi na-egbu egbu (IPV)',

            'hausa' => 'Wannan don sanar da ku cewa kuna buƙatar kawo ɗanku don OPV, rotavirus, penta, pcv'
        ];

        $six_months = [
            'english' =>
                'This is to inform you that you need to bring your child for vitamin A'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun Vitamin A'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka vitamin A'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar ku kawo ɗanku don bitamin A'
        ];

        $nine_months = [
            'english' =>
                'This is to inform you that you need to bring your child for measles and yellow fever vaccination.'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun awọn aarun ajakalẹ ati ajesara iba.'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka ịgba ọgwụ mgbochi ọrịa na ọnya na-acha odo odo.'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar ɗaukar ɗan ku don rigakafin cutar huhu da zazzabin zazzabi.'
        ];

        $twelve_months = [
            'english' =>
                'This is to inform you that you need to bring your child for meningococcal conjugate, PCV booster, DTP/DTap/TdaP booster, vitamin A, OPV booster'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ wa fun conjugate meningococcal, lagbara PCV, lagbara DTP / DTap / TdaP, Vitamin A, lagbara OPV'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka nkụchi meningococcal, boolu PCV, DTP / DTap / TdaP, vitamin A, OPV booster.'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar kawo ɗanku don meningococcal conjugate, PCV mai ƙara, DTP / DTap / TdaP booster, bitamin A, OPV mai kara amfani.'
        ];

        $fifteen_months = [
            'english' =>
                'This is to inform you that you need to bring your child for measles, mumps, rubella (MMR), Chicken pox vaccination'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun awọn kiko-arun, awọn mumps, rubella (MMR), ajesara adie'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka ọrịa na-efe efe, mumps, rubella (MMR), Chicken pox ịgba ọgwụ mgbochi.'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar ɗaukar yaranku don cutar kyanda, ƙuraje, rubella (MMR), Chicken pox allurar.'
        ];

        $eighteen_months = [
            'english' =>
                'This is to inform you that you need to bring your child for MMR, chicken pox, hepatitis A'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun MMR, pox chicken, jedojedo A'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka MMR, pox chicken, hepatitis A'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar ku kawo ɗanku don MMR, pox chicken, hepatitis A'
        ];

        $two_years = [
            'english' =>
                'This is to inform you that you need to bring your child for typhoid fever and hepatitis A vaccination.'
            ,

            'yoruba' =>
                'Eyi ni lati sọ fun ọ pe o nilo lati mu ọmọ rẹ fun iba iba ati ajesara jedojedo'
            ,
            
            'igbo' =>
                'Nke a bụ iji gwa gị na ịkwesịrị ịkpọtara nwa gị maka ịba ahụ ọkụ na ịba ọcha n\'anya A.'
            ,

            'hausa' =>
                'Wannan don sanar da ku cewa kuna buƙatar ku kawo ɗanku don zazzabin Typhoid da cutar hepatitis A.'
        ];

        $vaccination_sms_samples = [
            'at_birth' => $at_birth,
            'six_weeks' => $six_weeks,
            'ten_weeks' => $ten_weeks,
            'fourteen_weeks' => $fourteen_weeks,
            'six_months' => $six_months,
            'nine_months' => $nine_months,
            'twelve_months' => $twelve_months,
            'fifteen_months' => $fifteen_months,
            'eighteen_months' => $eighteen_months,
            'two_years' => $two_years
        ];

        foreach ($vaccination_sms_samples as $interval => $sms_samples) {
            foreach ($sms_samples as $language => $sms) {
                VaccinationSmsSample::create([
                    'interval' => $interval,
                    'language' => $language,
                    'sms' => $sms
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccination_sms_sample');
    }
}
