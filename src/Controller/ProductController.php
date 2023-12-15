<?php

namespace App\Controller;

use App\Entity\Product;
use App\Authentication\SecurityToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/products/load', name: 'load_products', methods: ['POST'])]
    public function loadProducts(Request $request): JsonResponse
    {
        try {
            // Check authentication
            if (!SecurityToken::validateToken()) {
              return new JsonResponse(['success' => false, 'error' => 'Invalid Token'], JsonResponse::HTTP_UNAUTHORIZED);
            }

            $data = json_decode($request->getContent(), true);

            // Validate and load records
            if (!empty($data) && is_array($data)) {
                foreach ($data as $productData) {
                    $product = new Product();
                    $product->setSku($productData['sku']);
                    $product->setProductName($productData['product_name']);
                    $product->setDescription($productData['description']);
                    $product->setCreatedAt(new \DateTimeImmutable());

                    // Persist the entity
                    $this->entityManager->persist($product);
                }

                // Flush changes to the database
                $this->entityManager->flush();

                return new JsonResponse(['success' => true, 'message' => 'Records loaded successfully'], JsonResponse::HTTP_OK);
              } else {
                throw new \Exception('Invalid JSON payload');
            }
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/products/update', name: 'update_products', methods: ['POST'])]
    public function updateProducts(Request $request): JsonResponse
    {
        if (!SecurityToken::validateToken()) {
          return new JsonResponse(['success' => false, 'error' => 'Invalid Token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return $this->json(['error' => 'Invalid JSON payload'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $updatedSkus = [];
        $errors = [];

        foreach ($data as $productData) {
            $sku = $productData['sku'] ?? null;

            if ($sku !== null) {
                $product = $this->entityManager->getRepository(Product::class)->findOneBy(['sku' => $sku]);

                if ($product instanceof Product) {
                    $product->updateFromPayload($productData);

                    $this->entityManager->flush();

                    $updatedSkus[] = $sku;
                } else {
                    $errors[] = "Product with SKU $sku not found.";
                }
            } else {
                $errors[] = 'SKU not provided in payload.';
            }
        }

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json(['updated_skus' => $updatedSkus], JsonResponse::HTTP_OK);
    }

    #[Route('/api/products/list', name: 'list_products', methods: ['GET'])]
    public function listProducts(): JsonResponse
    {
        if (!SecurityToken::validateToken()) {
          return new JsonResponse(['success' => false, 'error' => 'Invalid Token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $productList = [];
        foreach ($products as $product) {
            $productList[] = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'product_name' => $product->getProductName(),
                'description' => $product->getDescription(),
                'created_at' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $product->getUpdateAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json(['products' => $productList], JsonResponse::HTTP_OK);
    }

}
