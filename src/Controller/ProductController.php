<?php

namespace App\Controller;

use App\Dto\ParserRequestDto;
use App\Dto\ParserResponseDto;
use App\Entity\Product;
use App\Form\ParsingType;
use App\Form\ProductType;
use App\Parser\Parser;
use App\Parser\Service\ParserFactory;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ParserRequestDto $parserRequestDTO): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        $parsing_url = $request->request->get("parsing_url")?? ""  ;
        $parserRequestDTO->setParsingUrl($parsing_url);

        $form2 = $this->createForm(ParsingType::class,$parserRequestDTO,[
            'action' => $this->generateUrl(
                'app_product_new',
                ['id' => $product->getId()]),
            'method' => 'POST',
        ]);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {

            $parser = new Parser( new ParserFactory );

            $response = $parser->parsing($parserRequestDTO);
            $responseDto = $serializer->deserialize($response,ParserResponseDto::class, 'json');

            $form->get('name')->setData($responseDto->name);
            $form->get('price')->setData($responseDto->price);
            $form->get('img_url')->setData($responseDto->img_url);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, SerializerInterface $serializer, ParserRequestDto $parserRequestDTO ): Response
    {

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        $parsing_url = $request->request->get("parsing_url")?? ""  ;
        $parserRequestDTO->setParsingUrl($parsing_url);

        $form2 = $this->createForm(ParsingType::class,$parserRequestDTO,[
            'action' => $this->generateUrl(
                'app_product_edit',
                ['id' => $product->getId()]),
            'method' => 'POST',
        ]);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {

            $parser = new Parser( new ParserFactory  );

            $response = $parser->parsing($parserRequestDTO);
            $responseDto = $serializer->deserialize($response,ParserResponseDto::class, 'json');

            $form->get('name')->setData($responseDto->name);
            $form->get('price')->setData($responseDto->price);
            $form->get('img_url')->setData($responseDto->img_url);
        }
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

}
