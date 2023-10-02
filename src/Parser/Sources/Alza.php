<?php


namespace App\Parser\Sources;


use App\Parser\Contracts\SourceInterface;

class Alza implements SourceInterface
{
    public function getNameSelector(): string{
        return 'h1';
    }
    public function getImageUrlSelector(): string{
        return 'div.detailGallery-alz-5 img';
    }
    public function getPriceSelector(): string{
        return 'div.price-box__prices span.price-box__price';
    }
    public function getWrapperSelector(): string{
        return 'body';
    }

}