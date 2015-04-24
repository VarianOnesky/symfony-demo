<?php

namespace Company\Bundle\DataBundle\Controller;

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
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        return new Response('Created Product id '.$product->getId());
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
}
