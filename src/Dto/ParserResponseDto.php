<?php


namespace App\Dto;

class ParserResponseDto
{

    public ?string $name = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getImgUrl(): ?string
    {
        return $this->img_url;
    }

    /**
     * @param string|null $img_url
     */
    public function setImgUrl(?string $img_url): void
    {
        $this->img_url = $img_url;
    }

    public ?float $price = null;

    public ?string $img_url = null;
}