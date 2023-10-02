<?php


namespace App\Parser\Sources;


use App\Parser\Contracts\SourceInterface;

class AmazonEs implements SourceInterface
{
    public function getNameSelector(): string{
        return 'h1#title span';
    }
    public function getImageUrlSelector(): string{
        return 'div#imgTagWrapperId img';
    }
    public function getPriceSelector(): string{
        return 'div#corePriceDisplay_desktop_feature_div span.a-price-whole';
    }
    public function getWrapperSelector(): string{
        return '#ppd';
    }

}