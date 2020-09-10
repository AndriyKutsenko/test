<?php

namespace App\Controller;

use App\Service\ProductManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package App\Controller
 *
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductManager
     */
    private $productManager;

    /**
     * ProductController constructor.
     * @param ProductManager $productManager
     */
    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getListAction()
    {
        $products = $this->productManager->getProducts();

        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        return $this->render(
            'product-list.html.twig',
            [
                'products' => $products,
            ],
            $response
        );
    }

    /**
     * @Route("/add", methods={"GET"})
     */
    public function getAddPageAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        return $this->render(
            'product-add.html.twig',
            [],
            $response
        );
    }

    /**
     * @Route("/", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addAction(Request $request)
    {
        $this->productManager->createProduct($request->request->all());

        return new Response();
    }

    /**
     * @Route("/{productId}", methods={"GET"})
     *
     * @param int $productId
     * @return Response
     */
    public function getItemAction(int $productId)
    {
        $product = $this->productManager->getProduct($productId);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        return $this->render(
            'product-view.html.twig',
            [
                'id' => $productId,
                'name' => $product['name'],
                'cost' => $product['cost'],
                'date' => $product['date'],
            ],
            $response
        );
    }

    /**
     * @Route("/{productId}/edit", methods={"GET"})
     *
     * @param int $productId
     * @return Response
     */
    public function editItemAction(int $productId)
    {
        $product = $this->productManager->getProduct($productId);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        return $this->render(
            'product-edit.html.twig',
            [
                'id' => $productId,
                'name' => $product['name'],
                'cost' => $product['cost'],
            ],
            $response
        );
    }

    /**
     * @Route("/{productId}", methods={"PUT"})
     *
     * @param int $productId
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editAction(int $productId, Request $request)
    {
        $this->productManager->saveProduct($productId, $request->request->all());

        return new Response();
    }

    /**
     * @Route("/{productId}", methods={"DELETE"})
     *
     * @param int $productId
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAction(int $productId)
    {
        $this->productManager->deleteProduct($productId);

        return new Response();
    }

    /**
     * @Route("/search/{productName}", methods={"GET"})
     *
     * @param string $productName
     * @return Response
     */
    public function getSearchAction(string $productName)
    {
        $products = $this->productManager->searchProduct($productName);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        return $this->render(
            'product-list.html.twig',
            [
                'products' => $products,
                'productName' => $productName,
            ],
            $response
        );
    }
}
