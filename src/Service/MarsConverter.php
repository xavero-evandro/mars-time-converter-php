<?php

namespace App\Service;

date_default_timezone_set("UTC");
ini_set('precision', 17);

class MarsConverter
{
    const TAILOFFSET = 37;

    public function __construct()
    {
    }

    private function getRightMillisecUTCTime(int $time): int
    {
        return (int) preg_replace("/[,|.]/", "", number_format($time, 3));
    }

    private function getJulianDateUT(float $millisecs): float
    {
        return 2440587.5 + $millisecs / 8.64e7;
    }

    private function getJulianDateTT(float $julianDateUT, $tailOffset): float
    {
        return $julianDateUT + ($tailOffset + 32.184) / 86400;
    }

    private function getJ2000(float $jdTt): float
    {
        return $jdTt - 2451545.0;
    }

    private function getMarsSolDate(float $j2000): float
    {
        return ($j2000 - 4.5) / 1.027491252 + 44796.0 - 0.00096;
    }

    private function getCoordinatedMarsTime(float $msd): float
    {
        return number_format(fmod((24 * $msd), 24), 17);
    }

    private function addCommasToMarsSolDate(string $msd): string
    {
        $x = explode(".", $msd);
        $x1 = $x[0];
        $x2 = count($x) > 1 ? "." . $x[1] : "";
        $rgx = "/(\d+)(\d{3})/";
        while (preg_match($rgx, $x1)) {
            $x1 = preg_replace($rgx, "$1,$2", $x1);
        }
        return $x1 . $x2;
    }

    private function formatMarsSolDateToHMS(float $mtc): string
    {
        $x = $mtc * 3600;
        $hh = floor($x / 3600);
        if ($hh < 10) $hh = "0" . $hh;
        $y = fmod($x, 3600);
        $mm = floor($y / 60);
        if ($mm < 10) $mm = "0" . $mm;
        $ss = round(fmod($y, 60));
        if ($ss < 10) $ss = "0" . $ss;
        return $hh . ":" . $mm . ":" . $ss;
    }

    public function getMarsTime(\DateTime $timeUTC): array
    {
        $millis = self::getRightMillisecUTCTime($timeUTC->getTimestamp());
        $jdUt = self::getJulianDateUT($millis);
        $jdTt = self::getJulianDateTT($jdUt, self::TAILOFFSET);
        $j2000 = self::getJ2000($jdTt);
        $msd = self::getMarsSolDate($j2000);
        $mtc = self::getCoordinatedMarsTime($msd);
        $marsSolDate = self::addCommasToMarsSolDate(number_format($msd, 5));
        $marsCoordinateMarsTime = self::formatMarsSolDateToHMS($mtc);
        return [
            'MarsSolDate' => $marsSolDate,
            'MartianCoordinatedTime' => $marsCoordinateMarsTime
        ];
    }
}
