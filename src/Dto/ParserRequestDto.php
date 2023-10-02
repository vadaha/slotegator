<?php


namespace App\Dto;

class ParserRequestDto
{

    public string $parsing_url;

    /**
     * @return string
     */
    public function getParsingUrl(): string
    {
        return $this->parsing_url;
    }

    /**
     * @param string $parsing_url
     */
    public function setParsingUrl(string $parsing_url): void
    {
        $this->parsing_url = $parsing_url;
    }
}