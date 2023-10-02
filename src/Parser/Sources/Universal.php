<?php


namespace App\Parser\Sources;


use App\Parser\Contracts\SourceInterface;

class Universal implements SourceInterface
{
    public function getNameSelector(): string{
        return 'h1';
    }
    public function getImageUrlSelector(): string{
        return 'img';
    }
    public function getPriceSelector(): string{
        return 'span.a-price';
    }
    public function getWrapperSelector(): string{
        return '.home';
    }

}