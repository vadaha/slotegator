<?php


namespace App\Parser\Service;


use App\Parser\Contracts\SourceInterface;
use App\Parser\Sources\Alza;
use App\Parser\Sources\AmazonEs;
use App\Parser\Sources\Universal;

class ParserFactory
{
    public const SOURCE_ALZA = 'alza.cz';
    public const SOURCE_AMAZON = 'amazon.es';
    public const SOURCE_UNIVERSAL = 'universal';

    public function createClass(string $type): SourceInterface
    {
        switch ($type) {
            case self::SOURCE_ALZA:
                return new Alza();
            case self::SOURCE_AMAZON:
                return new AmazonEs();
            default:
                return new Universal();
        }
    }
}