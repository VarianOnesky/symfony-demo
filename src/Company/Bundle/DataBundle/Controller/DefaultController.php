<?php

namespace Company\Bundle\DataBundle\Controller;

use Company\Bundle\DataBundle\Entity\Category;
use Company\Bundle\DataBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DataBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction()
    {
        $categoryName = "Main Product";

        $category = $this->getDoctrine()->getRepository('DataBundle:Category')
            ->findOneBy(array("name" => $categoryName));

        if (!$category) {
            $category = new Category();
            $category->setName($categoryName);
        }

        $product = new Product();
        $product->setName('Foo');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');
        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();

        $em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Created Product id '.$product->getId()
            .' and category id: '.$category->getId());
    }

    public function showAction($id)
    {
        $product = $this->getDoctrine()->getRepository('DataBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No Product found for id '.$id
            );
        }

        return $this->render(
            'DataBundle:Product:show.html.twig',
            array ('Product' => $product)
        );
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('DataBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No Product found for id '.$id
            );
        }

        $product->setName('This is a great Product!');
        $em->flush();

        return $this->redirectToRoute('data_show_product', array('id' => $id));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('DataBundle:Product')->find($id);

        $em->remove($product);
        $em->flush();
    }

    public function showProductsAction($id)
    {
        $category = $this->getDoctrine()->getRepository('DataBundle:Category')
            ->find($id);

        $products = $category->getProducts();

        return $this->render(
            'DataBundle:Product:show-by-category.html.twig',
            array ('products' => $products)
        );
    }
}
