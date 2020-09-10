<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\DataTransformer\CostTransformer;
use App\Repository\ProductRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Intl\Timezones;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ProductManager
 * @package App\Service
 */
class ProductManager
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * ProductManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->productRepository = $entityManager->getRepository(Product::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createProduct(array $params)
    {
        $product = new Product();

        $cost = 0;
        if (isset($params['cost'])) {
            $transformer = new CostTransformer();
            $cost = $transformer->reverseTransform((float)(str_replace(',', '.', $params['cost'])));
        }

        $product->setName($params['name']);
        $product->setCost($cost);
        $product->setCreatedDate(new DateTime());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product->getId();
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        $products = $this->productRepository->findAll();
        $transformer = new CostTransformer();

        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'cost' => $transformer->transform($product->getCost()),
                'createdDate' => date('Y-m-d', $product->getCreatedDate()->getTimestamp()),
            ];
        }

        return $result;
    }

    /**
     * @param int $productId
     * @return array
     */
    public function getProduct(int $productId)
    {
        $product = $this->productRepository->findOneBy(['id' => $productId]);

        $result = [];
        if ($product) {
            $transformer = new CostTransformer();
            $result = [
                'name' => $product->getName(),
                'cost' => $transformer->transform($product->getCost()),
                'date' => date('Y-m-d', $product->getCreatedDate()->getTimestamp()),
            ];
        }
        return $result;
    }

    /**
     * @param int $productId
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveProduct(int $productId, array $params)
    {
        $product = $this->productRepository->findOneBy(['id' => $productId]);

        if ($product) {
            $cost = 0;
            if (isset($params['cost'])) {
                $transformer = new CostTransformer();
                $cost = $transformer->reverseTransform((float)(str_replace(',', '.', $params['cost'])));
            }

            $product->setName($params['name']);
            $product->setCost($cost);

            $this->entityManager->flush();
        }
    }

    /**
     * @param $productId
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteProduct(int $productId)
    {
        $product = $this->productRepository->findOneBy(['id' => $productId]);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }

    /**
     * @param string $productName
     * @return array
     */
    public function searchProduct(string $productName)
    {
        $products = $this->productRepository->getByName($productName);
        $transformer = new CostTransformer();

        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'cost' => $transformer->transform($product->getCost()),
                'createdDate' => date('Y-m-d', $product->getCreatedDate()->getTimestamp()),
            ];
        }

        return $result;
    }
}
