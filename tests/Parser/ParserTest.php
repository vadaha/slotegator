<?php

namespace App\Tests\Parser;

use App\Dto\ParserRequestDto;
use App\Dto\ParserResponseDto;
use App\Parser\Parser;
use App\Parser\Service\ParserFactory;
use App\Parser\Sources\Alza;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\Client;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class ParserTest extends TestCase
{


    public function testParsing()
    {

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array(new JsonEncoder()));
        $parserRequestDTO = new ParserRequestDto;
        $parsing_url = "https://www.alza.cz/iphone-15-pro?dq=7927759";
        $parser = new Parser( new ParserFactory, $serializer );
        $parserRequestDTO->setParsingUrl($parsing_url);

        $response = $parser->parsing($parserRequestDTO);
        $responseDto = $serializer->deserialize($response,ParserResponseDto::class, 'json');


        $this->assertNotEmpty($responseDto);

        $this->assertIsFloat($responseDto->getPrice());
        $this->assertGreaterThanOrEqual(1, $responseDto->getPrice());

        $this->assertNotEmpty($responseDto->getName());

        $this->assertStringStartsWith('https:', $responseDto->getImgUrl());

    }
}
