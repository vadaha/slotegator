<?php


namespace App\Parser\Contracts;


interface SourceInterface
{
    public function getNameSelector(): string;
    public function getImageUrlSelector(): string;
    public function getPriceSelector(): string;
    public function getWrapperSelector(): string;
}