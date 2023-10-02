<?php


namespace App\Parser;
use App\Dto\ParserRequestDto;
use App\Dto\ParserResponseDto;
use App\Parser\Service\ParserFactory;
use App\Scraper\Contracts\SourceInterface;
use Symfony\Component\Panther\Client;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Parser
{
    public function __construct(
        private ParserFactory $parserFilterFactory
    ) {      }
    public function parsing(ParserRequestDto $parserRequestDto): string
    {
        $type = $this->detectSiteType($parserRequestDto);
        $parserFilter = $this->parserFilterFactory->createClass($type);

        $args = [
            '--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
            '--window-size=1600,1100',
            '--headless',
            '--disable-gpu',
        ];
        //$client = Client::createChromeClient("", $args, [1]); ///home/user/slot/slotegrator/drivers/chromedriver
        $client = Client::createChromeClient("/home/user/slot/slotegrator/drivers/chromedriver", $args, [1]);

        $crawler = $client->request('GET', $parserRequestDto->getParsingUrl());

        $block1 = $crawler->filter($parserFilter->getWrapperSelector())->count() ?
            $crawler->filter($parserFilter->getWrapperSelector()) :
            null ;

        $responseDto  = new ParserResponseDto;
        $responseDto->name = $block1->filter($parserFilter->getNameSelector())->count() ?
            $block1->filter($parserFilter->getNameSelector())->text() :
            null;
        $responseDto->img_url = $block1->filter($parserFilter->getImageUrlSelector())->count() ?
            $block1->filter($parserFilter->getImageUrlSelector())->attr("src") :
            null;
        $price = $block1->filter($parserFilter->getPriceSelector())->count() ?
            $block1->filter($parserFilter->getPriceSelector())->text() :
            null;

        $price = str_replace(['-',' ','US','$','€'],"",$price);
        $price = str_replace(["\n"],".",$price);

        $responseDto->price = (float)$price;

        $encoders = [new  JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        return $serializer->serialize($responseDto,'json');
    }
    public function detectSiteType(parserRequestDto $parserRequestDto): string
    {
        $hostname = parse_url($parserRequestDto->getParsingUrl(), PHP_URL_HOST);
        $hostname = str_replace("www.","",$hostname);
        $hostname = mb_strtolower($hostname, 'UTF-8');
        return $hostname;
    }
}